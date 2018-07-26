<?php

namespace App\Http\Controllers;

use App\BranchCourse;
use function App\Helper\admin;
use function App\Helper\trainee;
use App\HistoryDetail;
use App\Reservation;
use App\Schedule;
use App\Trainee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class TraineesController extends Controller
{
    public function index()
    {
        return view('trainees.index', [
            'trainees' => Trainee::withTrashed()->get()
        ]);
    }

    public function show($trainee)
    {
        return view('trainees.show', [
            'trainee' => Trainee::withTrashed()->where('id', $trainee)->first()
        ]);
    }

    public function register(Request $request)
    {
        return view('trainees.register');
    }

    public function store(Request $request)
    {
        $userDetails = $request->validate([
            'username' => 'required|min:3|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $traineeInfo = $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'mobile_number' => 'required|unique:trainees',
            'rank' => 'required',
            'birth_date' => 'required',
            'address' => 'required'
        ]);

        $userDetails['password'] = bcrypt($userDetails['password']);
        $user = User::create($userDetails);

        $traineeInfo['telephone_number'] = $request->telephone_number;
        $traineeInfo['company'] = $request->company;
        $traineeInfo['user_id'] = $user->id;

        $trainee = Trainee::create($traineeInfo);

        $request->session()->flash('info', [
            'title' => 'Registration Successful!',
            'type' => 'success',
            'text' => 'You can now log in your account and start reserving a courses!',
            'confirmButtonColor' => '#8db600',
            'confirmButtonText' => 'OKAY, COOL!',
        ]);

        return redirect()->route('trainee.login');
    }

    public function login()
    {
        return view('trainees.login');
    }

    public function home()
    {
        return view('layouts.trainee-main');
    }

    public function schedules(Request $request)
    {
        $branch = $request->has('branch')? $request->branch : null;
        $schedules = null;
        $reservations = null;
        $reservedCoursesIds = Reservation::select('course_id')->where('trainee_id', trainee()->id)->get();
        $schedules = Schedule::whereNotIn('course_id', $reservedCoursesIds)->get();

        if($branch) {
            $schedules = Schedule::whereHas('branch', function ($query) use ($request, $reservedCoursesIds) {
                $query->where('name', $request->branch)->whereNotIn('course_id', $reservedCoursesIds);
            })->get();
        }

        return view('trainees.schedules', compact('branch', 'schedules', 'reservations'));
    }

    public function showSchedule(Schedule $schedule, Request $request)
    {
        return view('trainees.schedule-show', compact('schedule'));
    }

    public function reservations(Request $request)
    {
        $reservations = null;

        if ($request->has('status')) {
            $reservations = Reservation::where('status', $request->status)
                                ->where('trainee_id', trainee()->id)->where('seen', 0)
                                ->withTrashed()->get()->unique('code')->sortByDesc('created_at')->values()->all();
        } else {
            $reservations = Reservation::where('trainee_id', trainee()->id)
                ->withTrashed()->get()->unique('code')->sortByDesc('created_at')->values()->all();
        }

        return view('trainees.reservations', compact('reservations'));
    }

    public function showReservation($reservation)
    {
        $reservation = Reservation::where('id', $reservation)->withTrashed()->first();

        foreach($reservation->paymentTransactions as $paymentTransaction) {
            if ($paymentTransaction->status == 'confirmed' || $paymentTransaction->status == 'confirmed') {
                $paymentTransaction->seen = 1;
                $paymentTransaction->save();
            }
        }

        if ($reservation->status == 'paid' || $reservation->status == 'registered') {
            $reservation->seen = 1;
            $reservation->save();
        }

        return view('trainees.reservation-show', compact('reservation'));
    }

    public function update(Trainee $trainee, Request $request)
    {
        if ($request->has('email')) {
            $request->validate([
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($trainee->user->id)
                ],
                'mobile_number' => [
                    'required',
                    Rule::unique('trainees')->ignore($trainee->id)
                ],
                'first_name' => 'required',
                'middle_name' => 'required',
                'last_name' => 'required',
                'birth_date' => 'required',
                'rank' => 'required',
                'remarks' => 'required|min:10',
            ]);

            $user = $trainee->user;
            $user->email = $request->email;
            $user->save();

            $trainee->first_name = $request->first_name;
            $trainee->middle_name = $request->middle_name;
            $trainee->last_name = $request->last_name;
            $trainee->birth_date = $request->birth_date;
            $trainee->rank = $request->rank;
            $trainee->company = $request->company;
            $trainee->mobile_number = $request->mobile_number;
            $trainee->telephone_number = $request->telephone_number;
            $trainee->save();

            HistoryDetail::create([
                'trainee_id' => $trainee->id,
                'updated_by' => admin()->id,
                'log' => 'updated trainee information',
                'remarks' => $request->remarks,
            ]);
        } elseif ($request->has('status') and $request->status != 'active') {
            $request->validate([
                'status' => 'required',
                'remarks' => 'required',
            ]);

            $trainee->status = $request->status;
            $trainee->save();

            HistoryDetail::create([
                'trainee_id' => $trainee->id,
                'updated_by' => admin()->id,
                'log' => 'updated trainee information',
                'remarks' => $request->remarks,
            ]);
        }

        return back();
    }
}
