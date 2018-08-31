<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\Branch;
use function App\Helper\admin;
use function App\Helper\adminCan;
use function App\Helper\computePayment;
use function App\Helper\trainee;
use function App\Helper\user;
use App\HistoryDetail;
use App\Mail\CourseReserved;
use App\Notifications\CourseRegistered;
use App\Notifications\PaymentHasBeenConfirmed;
use App\Notifications\PaymentTransactionConfirmed;
use App\PaymentTransaction;
use App\Reservation;
use App\Schedule;
use App\Trainee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;

class ReservationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can.access']);
    }

    public function index(Request $request)
    {
        $view = null;
        $branch = null;
        $trainee = null;

        if ($request->has('branch')) {
            $branch = Branch::where('name', $request->branch)->first();

            $reservations = Reservation::whereHas('schedule', function ($query) use ($branch) {
                                            $query->where('branch_id', $branch->id);
                                        })->get()->sortByDesc('created_at');
        } elseif ($request->has('status') && $request->status == 'cancelled') {
            $reservations = Reservation::withTrashed()->whereHas('schedule', function ($query) {
                                $query->where('branch_id', admin()->branch->id);
                            })->where('status', $request->status)->get()->sortByDesc('created_at');

            $branch = admin()->branch;
        } elseif ($request->has('status') && $request->status == 'pending') {
            $reservations = Reservation::withTrashed()->whereHas('schedule', function ($query) {
                $query->where('branch_id', admin()->branch->id);
            })->where('status', $request->status)->get()->sortByDesc('created_at');

            $branch = admin()->branch;
        } elseif ($request->has('status')) {
            $reservations = Reservation::whereHas('schedule', function ($query) {
                                $query->where('branch_id', admin()->branch->id);
                            })->where('status', $request->status)->get()->sortByDesc('created_at');

            $branch = admin()->branch;
        } elseif ($request->has('trainee')) {
            $reservations = Reservation::withTrashed()->where('trainee_id', $request->trainee)->get()->sortByDesc('created_at');

            $trainee = Trainee::find($request->trainee);
        } else {
            $reservations = Reservation::all()->sortByDesc('created_at');
        }

        return view('reservations.index', compact('branch','reservations', 'trainee'));
    }

    public function show($reservation, Request $request)
    {
        $reservation = Reservation::withTrashed()->find($reservation);
        // if any update has been made, mark it as seen
        if ($reservation->paymentTransactions) {
            foreach ($reservation->paymentTransactions->where('seen', 0) as $paymentTransaction) {
                $paymentTransaction->seen = 1;
                $paymentTransaction->save();
            }
        }

        return view('reservations.show', compact('reservation'));
    }

    public function store(Schedule $schedule ,Request $request)
    {
        if ($request->has('confirmation')) {
            $code = Reservation::__callStatic('generateCode', [$schedule]);

            $reservation = Reservation::create([
                'branch_id' => $schedule->branchCourse->branch->id,
                'course_id' => $schedule->branchCourse->course_id,
                'trainee_id' => auth()->user()->trainee->id,
                'schedule_id' => $schedule->id,
                'code' => $code, // format: 'R{userID}{year}-{branch_code}{branch_reservation_count_for_current_year}'
                'original_price' => $schedule->branchCourse->originalPrice->value,
                'balance' => computePayment($schedule->branchCourse->originalPrice->value, $schedule->discount),
                'discount' => $schedule->discount,
            ]);

            Mail::to(auth()->user())->queue(new CourseReserved($reservation));

            $request->session()->flash('info', [
                'title' => 'Course Reserved!',
                'type' => 'success',
                'text' => 'An email has been sent to ' . user()->email . ' that contains the reservation information' .
                ' and payment procedures. Thank you for using ' . config('app.name'),
                'confirmButtonColor' => '#DD6B55',
                'confirmButtonText' => 'OKAY, COOL!',
            ]);

            HistoryDetail::create([
                'reservation_id' => $reservation->id,
                'updated_by' => 1,
                'remarks' => 'new reservation',
                'log' => 'reservation request received from trainee ' . trainee()->fullName(),
            ]);

            return redirect()->route('trainee-reservations.show', $reservation->id);
        } else {
            $request->session()->flash('info', [
                'title' => 'Course Not Reserved!',
                'type' => 'warning',
                'text' => 'To be able to reserve this course you MUST check the confirmation box',
                'confirmButtonColor' => '#DD6B55',
                'confirmButtonText' => 'I WILL CHECK IT',
            ]);

            return back();
        }
    }

    public function update(Reservation $reservation, Request $request)
    {
        $request->validate([
            'remarks' => 'required',
        ]);

        $responsible = admin()? admin() : trainee();

        HistoryDetail::create([
            'reservation_id' => $reservation->id,
            'updated_by' => $responsible->id,
            'remarks' => $request->remarks,
            'log' => 'reservation has ben cancelled, please see remarks',
        ]);

        $reservation->status = 'cancelled';
        $reservation->receive_payment = 0;
        $reservation->save();

        // delete cancelled reservation to eliminate query complications
        $reservation->delete();

        return back();
    }

    public function confirm(Reservation $reservation, Request $request)
    {
        $status = null;
        $amount = 0;
        if (adminCan('confirm reservation') || adminCan('accounting officer') and $reservation->status == 'pending') {
            $request->validate([
                'amount' => 'required',
                'number' => 'required',
            ]);

            $amount = str_replace(',', '', $request->amount) * 1.00;
            $toBePaid = computePayment($reservation->original_price, $reservation->discount);
            $status = $this->getReservationStatus($amount, $toBePaid);

            $balance = computePayment($reservation->original_price, $reservation->discount) - $amount;
        } elseif (adminCan('confirm reservation') || adminCan('accounting officer') && $reservation->status == 'underpaid') {
            $request->validate([
                'amount' => 'required',
                'number' => 'required',
            ]);

            $amount = str_replace(',', '', $request->amount) * 1.00;
            $status = $this->getReservationStatus($amount, $reservation->balance);

            $balance = $reservation->balance - $amount;
        } else {
            $request->session()->flash('info', [
                'title' => 'Warning!',
                'type' => 'warning',
                'text' => 'Your account is not allowed to CONFIRM RESERVATION PAYMENTS! Please ask the system ' .
                'administrator to add this action to your account or ask another admin that can do the requested task.',
                'confirmButtonColor' => '#DD6B55',
                'confirmButtonText' => 'CONTINUE',
            ]);

            return back();
        }
        // normalize balance
        $balance = $balance >= 0? 0 : $balance * -1;

        // update reservation
        $reservation->balance = $balance;
        $reservation->status = $status;
        if ($reservation->status != 'underpaid') {
            $reservation->receive_payment = 0;
            $reservation->confirmed_by = admin()->id;
        }
        elseif ($reservation->status == 'underpaid') $reservation->receive_payment = 1;
        $reservation->save();

        HistoryDetail::create([
            'reservation_id' => $reservation->id,
            'updated_by' => admin()->id,
            'remarks' => 'confirmed payment',
            'log' => "received $request->amount as per " . admin()->full_name,
        ]);

        $paymentTransaction = PaymentTransaction::where('number', $request->number)->first();
        $paymentTransaction->received_amount = $amount;
        $paymentTransaction->status = 'confirmed';
        $paymentTransaction->save();

        $trainee = Trainee::find($reservation->trainee_id);
        $user = $trainee->user;

        $admins = Administrator::whereHas('roles', function ($query) {
            $query->where('role_id', 6)->orWhere('role_id', 7);
        })->where('branch_id', $reservation->branch_id)->get();

        $user->notify(new PaymentHasBeenConfirmed($reservation)); // send email notification to trainee

        foreach ($admins as $admin) {
            $user = $admin->user;
            $user->notify(new PaymentTransactionConfirmed($reservation));
        } // send email notification to registration department

        $dev = User::find(1);
        $dev->notify(new PaymentTransactionConfirmed($reservation)); // send email copy for future reference

        return back();
    }

    public function registered(Reservation $reservation, Request $request)
    {
        if (adminCan('confirm registration') || adminCan('registration officer')) {
            $request->validate([
                'cor_number' => 'required'
            ]);

            try {
                $reservation->cor_number = $request->cor_number;
                $reservation->status = 'registered';
                $reservation->registered_by = auth()->user()->administrator->id;
                $reservation->save();
            } catch (QueryException $queryException) {
                if ($queryException->errorInfo[1] == 1062) {
                    $request->session()->flash('info', [
                        'title' => 'Impossible request!',
                        'type' => 'error',
                        'text' => 'Using of duplicate COR# is not allowed!',
                        'confirmButtonColor' => '#DD6B55',
                        'confirmButtonText' => 'CONTINUE',
                    ]);
                } else {
                    $request->session()->flash('info', [
                        'title' => 'An error has occurred',
                        'type' => 'warning',
                        'text' => 'An unexpected error has occurred please try again, if this message persists, ' . 
                        'please contact the developer',
                        'confirmButtonColor' => '#DD6B55',
                        'confirmButtonText' => 'CONTINUE',
                    ]);
                }

                return back();
            }

            $trainee = Trainee::find($reservation->trainee_id);
            $user = $trainee->user;

            $user->notify(new CourseRegistered($reservation));

            // create history details
            HistoryDetail::create([
                'reservation_id' => $reservation->id,
                'updated_by' => auth()->user()->administrator->id,
                'remarks' => 'trainee registered',
                'log' => 'marked trainee reservation as registered with cor#' . $request->cor_number,
            ]);
        } else {
            $request->session()->flash('info', [
                'title' => 'Warning!',
                'type' => 'warning',
                'text' => 'Your account is not allowed to CHANGE RESERVATION STATUS! Please ask the system' .
                    'administrator to add this action to your account or ask another admin that can do the requested task.',
                'confirmButtonColor' => '#DD6B55',
                'confirmButtonText' => 'CONTINUE',
            ]);
        }

        return back();
    }

    public function refund(Reservation $reservation, Request $request)
    {
        if (adminCan('refund excess payment') || adminCan('accounting officer')) {
            $request->validate([
                'amount' => 'required'
            ]);

            // create history details
            HistoryDetail::create([
                'reservation_id' => $reservation->id,
                'updated_by' => admin()->id,
                'remarks' => 'refunded excess payment',
                'log' => "refunded P $request->amount to trainee",
            ]);

            $amount = str_replace(',', '', $request->amount) * 1.00;

            $reservation->status = 'refunded';
            $reservation->save();
        } else {
            $request->session()->flash('info', [
                'title' => 'Warning!',
                'type' => 'warning',
                'text' => 'Your account is not allowed to REFUND EXCESS PAYMENT! Please ask the system' .
                    'administrator to add this action to your account or ask another admin that can do the requested task.',
                'confirmButtonColor' => '#DD6B55',
                'confirmButtonText' => 'CONTINUE',
            ]);
        }

        return back();
    }

    public function getReservationStatus($amount, $toBePaid)
    {
        $status = null;

        if ($amount == $toBePaid) $status = 'paid';
        elseif ($amount > $toBePaid) $status = 'overpaid';
        elseif ($amount < $toBePaid) $status = 'underpaid';

        return $status;
    }
}
