<?php

namespace App\Http\Middleware;

use function App\Helper\admin;
use function App\Helper\trainee;
use App\HistoryDetail;
use App\PaymentTransaction;
use App\Reservation;
use Carbon\Carbon;
use Closure;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $prefix = str_replace('/', '', $request->route()->getPrefix());
        if (optional(auth()->user()->administrator)->exists() && $prefix == 'admin') {
            if (admin()->status == 'deactivated') {
                $request->session()->flash('info', [
                    'not_allowed' => 'Your account has been deactivated by the administrators. If you think this is' .
                        ' incorrect, please call 888-2764 or email your concern at it@newsim.ph'
                ]);

                auth()->logout();

                return redirect(url('/admin/login'));
            } elseif (admin()->status == 'pending') {
                $request->session()->flash('info', [
                    'not_allowed' => 'Your account has not yet been activated by the administrators. If you think' .
                        ' this is incorrect, please call 888-2764 or email your concern at it@newsim.ph'
                ]);

                auth()->logout();

                return redirect(url('/admin/login'));
            }

            $newReservationsCount = Reservation::where('status', 'new')
                                                    ->where('status', '!=', 'expired')
                                                    ->where('branch_id', admin()->branch_id)
                                                    ->where('seen', 0)->get()->count();

            $newPaymentsCount = PaymentTransaction::whereHas('reservation', function ($query) {
                                                        $query->where('branch_id', admin()->branch_id);
                                                    })->where('status', 'new')
                                                    ->where('seen', 0)->get()->count();

            $newPaidReservationsCount = Reservation::where('status', 'paid')->where('seen', 0)->get()->count();

            view()->share([
                'newReservations' => $newReservationsCount,
                'newPayments' => $newPaymentsCount,
                'newPaidReservations' => $newPaidReservationsCount,
            ]);
//
//            $openReservations = Reservation::where('status', 'new')->orWhere('status', 'underpaid')
//                                                ->where('branch_id', admin()->branch_id)->get();
//
//            if ($openReservations->count() > 0) {
//                foreach($openReservations as $openReservation) {
//                    if (now()->startOfDay()->gt(Carbon::parse($openReservation->created_at)->startOfDay())) {
//                        HistoryDetail::create([
//                            'reservation_id' => $openReservation->id,
//                            'updated_by' => 1,
//                            'log' => 'reservation closed by the system',
//                            'remarks' => 'expired reservation',
//                        ]);
//
//                        $openReservation->status = 'expired';
//                        $openReservation->receive_payment = 0;
//                        $openReservation->save();
//                    }
//                }
//            }
        } elseif (optional(auth()->user()->trainee)->exists() && $prefix == 'trainee') {
            if (trainee()->status == 'inactive') {
                $request->session()->flash('info', [
                    'inactive' => 'Your account has been deactivated by the administrators. If you think this is' .
                        ' incorrect, please call 888-2764 or email your concern at it@newsim.ph'
                ]);

                auth()->logout();

                return redirect(url('/trainee/login'));
            }

            $newPaymentConfirmationsCount = PaymentTransaction::whereHas('reservation', function ($query) {
                                                $query->where('trainee_id', trainee()->id);
                                            })->where('status', 'confirmed')
                                            ->where('seen', 0)
                                            ->get()->count();

            $newRegisteredCoursesCount = Reservation::where('trainee_id', trainee()->id)
                                                        ->where('status', 'registered')
                                                        ->where('seen', 0)
                                                        ->get()->count();

            view()->share([
                'newPaymentConfirmations' => $newPaymentConfirmationsCount,
                'newRegisteredCourses' => $newRegisteredCoursesCount,
            ]);
        } else {
            return redirect('page-not-found');
        }

        return $next($request);
    }
}
