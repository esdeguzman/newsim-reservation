<?php

namespace App\Http\Middleware;

use function App\Helper\admin;
use function App\Helper\trainee;
use App\PaymentTransaction;
use App\Reservation;
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
