<?php

namespace App\Http\Controllers;

use function App\Helper\admin;
use function App\Helper\adminCan;
use function App\Helper\computePayment;
use function App\Helper\trainee;
use App\HistoryDetail;
use App\PaymentTransaction;
use App\Reservation;
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

        if (trainee()) {
            $data = [
                'reservation_id' => 'required',
                'number' => 'required',
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

        $request->validate($data);

        PaymentTransaction::create([
            'reservation_id' => $request->reservation_id,
            'number' => $request->number,
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
