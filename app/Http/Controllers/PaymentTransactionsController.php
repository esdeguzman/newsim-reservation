<?php

namespace App\Http\Controllers;

use App\Administrator;
use function App\Helper\admin;
use function App\Helper\adminCan;
use function App\Helper\computePayment;
use function App\Helper\trainee;
use App\HistoryDetail;
use App\Notifications\NewPaymentTransactionReceived;
use App\PaymentTransaction;
use App\Reservation;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;

class PaymentTransactionsController extends Controller
{
    public function store(Request $request)
    {
        $data = null;
        $type = null;
        $amount = null;
        $path = null;

        if (trainee()) {
            $data = [
                'reservation_id' => 'required',
                'number' => 'required',
                'deposit_slip' => 'required|mimes:jpeg,png',
            ];

            $type = 'bank deposit';
        } elseif (admin()) {
            $data = [
                'reservation_id' => 'required',
                'number' => 'required',
                'amount' => 'required',
            ];

            $type = 'on-site';
        }

        $request->validate($data,
            [
                'deposit_slip.required' => 'You need to upload the deposit slip to be able to add this payment.'
            ]);

        $reservation = Reservation::find($request->reservation_id);

        $path = $request->file('deposit_slip')->storeAs(
            'deposit_slips', "{$reservation->code}_{$request->number}.{$request->deposit_slip->extension()}"
        );

        PaymentTransaction::create([
            'reservation_id' => $request->reservation_id,
            'number' => $request->number,
            'slip_url' => $path,
            'type' => $type,
        ]);

        $reservation = Reservation::find($request->reservation_id);
        $reservation->receive_payment = 0; // set receive_payment flag to false to prevent payment flooding
        if ($reservation->status != 'underpaid') $reservation->status = 'pending';
        $reservation->save();

        HistoryDetail::create([
            'reservation_id' => $reservation->id,
            'updated_by' => 1,
            'remarks' => 'reservation has been paid',
            'log' => "trainee paid reservation via $type payment",
        ]);

        if (admin() && adminCan('confirm reservation')) {
            (new ReservationsController())->confirm($reservation, $request);
        }

        $admins = Administrator::whereHas('roles', function ($query) {
            $query->where('role_id', 3)->orWhere('role_id', 4);
        })->where('branch_id', $reservation->branch_id)->get();

        $dev = User::find(1);

        foreach ($admins as $admin) {
            $user = $admin->user;
            $user->notify(new NewPaymentTransactionReceived($reservation));
            $dev->notify(new NewPaymentTransactionReceived($reservation));
        }

        return back();
    }

    public function decline(PaymentTransaction $paymentTransaction, Request $request)
    {
        $remarks = $request->validate([ 'remarks' => 'required' ]);

        $paymentTransaction->status = 'declined';
        $paymentTransaction->save();

        $reservation = $paymentTransaction->reservation;
        $reservation->receive_payment = 1;
        $reservation->save();

        HistoryDetail::create([
            'reservation_id' => $paymentTransaction->reservation_id,
            'updated_by' => admin()->id,
            'remarks' => $request->remarks,
            'log' => "payment transaction # {$paymentTransaction->number} has been declined, please refer to remarks",
        ]);

        // todo: send email to trainee regarding declined payment

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
