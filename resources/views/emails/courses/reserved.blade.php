@component('mail::message')
# The course below is now temporarily reserved to you for 24hrs!

<br/>
Please make sure to pay it on time or the slot will be cancelled!
@component('mail::table')
    | Course                                                                       | Branch                                                      | Training Month                                                                           | Original Price                                                               | Discount                                                    | Pay                                                                                      |
    | :--------------------------------------------------------------------------- |:-----------------------------------------------------------:| :---------------------------------------------------------------------------------------:| :--------------------------------------------------------------------------- |:-----------------------------------------------------------:| ----------------------------------------------------------------------------------------:|
    | {{ strtoupper($reservation->schedule->branchCourse->details->code) }} | {{ strtoupper($reservation->schedule->branch->name) }}             | {{ $reservation->schedule->monthName() }}                                                | P {{ number_format($reservation->original_price, 2) }}                       | {{ \App\Helper\toPercentage($reservation->discount) }}      | P {{ \App\Helper\toReadablePayment($reservation->original_price, $reservation->discount) }} |
@endcomponent
---
<br/><br/>
__Payment Details__
<br/>
@component('mail::table')
|                                   |                                                                          |
| :-------------------------------- |:------------------------------------------------------------------------ |
| Bank                              | __BPI__                                                                  |
| Reservation Code/Reference Number | __{{ $reservation->code }}__                                             |
| Account Number                    | __442135985632__                                                         |
| Account Name                      | __NSCPI Bacolod__                                                        |
| Account Type                      | __Peso Savings__                                                         |
| Deadline                          | __{{ \App\Helper\toReadableExpirationDate($reservation->created_at) }}__ |
@endcomponent
---
<p>After paying, please make sure to secure your deposit slip as it will be your proof that you really have paid.<br/><br/>
To let us know the you have paid the reservation, log in to your account using the button below,
go to your reservation and click <b>ADD PAYMENT TRANSACTION NUMBER</b> and type in the transaction number indicated on your deposit slip.<br/><br/>
Adding of payment transaction number is also inclusive to the deadline indicated above.</p>

@component('mail::button', ['url' => "newsim-reservation.devyops.xyz/trainee/reservations/{$reservation->id}"])
LOG IN TO CONFIRM PAYMENT
@endcomponent

Thanks,<br/>
{{ config('app.name') }}
@endcomponent
