@extends('layouts.trainee-main')
@section('active-page')
    <li><a href="{{ route('trainee-reservations') }}"><b class="text-info text-capitalize">reservations</b></a></li>
    <li class="active"><span class="text-muted">{{ $reservation->code }}</span></li>
@stop
@section('page-content')
    <div class="col-md-12 block3">
        <div class="white-box printableArea">
            <h3 class="text-uppercase">
                <span class="pull-right">
                    <b class="label
                    @if($reservation->status == 'new') label-success
                    @elseif($reservation->status == 'cancelled' || $reservation->status == 'underpaid' || $reservation->status == 'expired') label-danger
                    @elseif($reservation->status == 'paid' || $reservation->status == 'registered') label-info
                    @elseif($reservation->status == 'pending' || $reservation->status == 'overpaid') label-warning
                    @endif
                    text-uppercase">{{ $reservation->status }}</b>
                </span>
                reservation code: <b class="text-info">{{ $reservation->code }}</b><br/>
                @if($reservation->cor_number)cor#: <b class="text-info">{{ $reservation->cor_number }}</b>@endif
            </h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left"> <address>
                            <h3> &nbsp;<b class="text-uppercase">{{ $reservation->schedule->branchCourse->details->description }} <sup class="text-info text-uppercase">{{ \App\Helper\toPercentage($reservation->discount) }} discount</sup></b></h3>
                            <p class="text-muted m-l-5">
                                <b class="text-danger text-uppercase">
                                @if(\App\Helper\trainee()->company) {{ \App\Helper\trainee()->company }}
                                @else not associated in a company
                                @endif
                                </b> <br/>
                                Address: {{ \App\Helper\trainee()->address }} <br/>
                                Born: {{ \App\Helper\toReadableDate(\App\Helper\trainee()->birth_date) }} <br/>
                        </address> </div>
                    <div class="pull-right text-right"> <address>
                            <p class="m-t-30"><b>Training Month :</b> <i class="fa fa-calendar"></i> {{ $reservation->schedule->monthName() }} {{ $reservation->schedule->year }}</p>
                            <p><b>Reservation Date :</b> <i class="fa fa-calendar"></i> {{ \App\Helper\toReadableDate($reservation->created_at) }}</p>
                            <p><b class="text-danger">Expiration Date :</b> <i class="fa fa-calendar"></i> {{ \App\Helper\toReadableExpirationDate($reservation->created_at) }}</p>
                        </address> </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover" id="payment_transactions">
                            <thead>
                            <tr>
                                <th>Transaction #</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Original Price</th>
                                <th class="text-center">Discount</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">Received</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($reservation->hasPaymentTransactions())
                                @foreach($reservation->paymentTransactions->sortByDesc('created_at') as $paymentTransaction)
                                <tr>
                                    <td>
                                        {{ $paymentTransaction->number }}
                                        <form action="#" method="get" enctype="multipart/form-data">
                                            <input type="file" name="bank_slip" />
                                        </form>
                                    </td>
                                    <td class="text-center"><span class="label label-success text-uppercase">{{ $paymentTransaction->status }}</span></td>
                                    <td class="text-right">P {{ number_format($paymentTransaction->reservation->original_price, 2) }}</td>
                                    <td class="text-center">{{ \App\Helper\toPercentage($paymentTransaction->reservation->discount) }}</td>
                                    <td class="text-right">P {{ \App\Helper\toReadablePayment($paymentTransaction->reservation->original_price, $paymentTransaction->reservation->discount) }}</td>
                                    <td class="text-right">P {{ number_format($paymentTransaction->received_amount, 2) }}</td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="m-t-30">
                        <br/><br/><br/><br/>
                        @if($reservation->confirmedBy) <p class="text-muted">Confirmed by: <b class="text-uppercase text-info">{{ $reservation->confirmedBy->full_name }}</b></p> @endif
                        @if($reservation->registeredBy) <p class="text-muted">Registered by: <b class="text-uppercase text-info">{{ $reservation->registeredBy->full_name }}</b></p> @endif
                    </div><br/>
                    <div class="clearfix"></div>
                    @if($reservation->status != 'cancelled')
                        <div class="text-right">
                            @if($reservation->receive_payment) <button class="btn btn-warning text-uppercase" data-toggle="modal" data-target=".confirm-payment">add payment transaction number</button> @endif
                            @if(! $reservation->isExpired()) <button class="btn btn-danger text-uppercase" data-toggle="modal" data-target=".cancel-reservation">cancel reservation</button> @endif
                            {{-- NOTE: USE IF NEED TO PRINT THIS <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>--}}
                        </div>
                    @endif
                    <hr>
                    <h3 class="text-uppercase"><b>reservation history</b></h3>
                    <div class="table-responsive m-t-20" style="clear: both;">
                        <table class="table table-hover" id="history">
                            <thead>
                            <tr>
                                <th class="text-capitalize">log</th>
                                <th class="text-capitalize">remarks</th>
                                <th class="text-capitalize">responsible</th>
                                <th class="text-capitalize">date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($reservation->hasHistory())
                                @foreach($reservation->history() as $history)
                                    <tr>
                                        <td>{{ $history->log }}</td>
                                        <td>{{ $history->remarks }}</td>
                                        <td>{{ $history->updatedBy->full_name }}</td>
                                        <td>{{ \App\Helper\toReadableDate($history->created_at) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modals -->

    <!-- cancel reservation -->
    <div class="modal fade cancel-reservation block3" tabindex="-1" role="dialog" aria-labelledby="cancelReservationLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="cancelReservationLabel">confirm action</h4> </div>
                <form action="{{ url("reservations/$reservation->id") }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        Cancelling a reservation requires <b class="text-uppercase text-info">remarks</b> for future reference. <br/><br/>
                        <textarea class="form-control form-material" name="remarks" rows="3"></textarea>
                        <a class="mytooltip pull-right" href="javascript:void(0)"> what's this?
                            <span class="tooltip-content5">
                                <span class="tooltip-text3">
                                    <span class="tooltip-inner2">To Cancel, <br/> Please enter the reason why this reservation is being cancelled.</span>
                                </span>
                            </span>
                        </a>
                        <br/><br/>
                        <b class="text-uppercase text-info">note! cancelling a fully-paid/confirmed/registered course is subject for fee penalties</b>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">undo, undo!</button>
                        <button class="btn btn-danger text-uppercase submit">continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /cancel reservation -->

    <!-- pay reservation -->
    <div class="modal fade confirm-payment block3" tabindex="-1" role="dialog" aria-labelledby="confirmPaymentLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="confirmPaymentLabel">confirm action</h4> </div>
                <form action="{{ \App\Helper\prefixedUrl() . '/payment-transactions' }}" method="post">
                    @csrf
                    <input type="text" name="reservation_id" value="{{ $reservation->id }}" hidden />
                    <div class="modal-body">
                        Please enter the bank transaction number # <br/><br/>
                        <input type="text" class="form-control form-material" name="number" placeholder="Payment transaction number">
                        <a class="mytooltip pull-right" href="javascript:void(0)"> what's this?
                            <span class="tooltip-content5">
                                <span class="tooltip-text3">
                                    <span class="tooltip-inner2">To Confirm, <br/> Please enter the exact bank transaction number.</span>
                                </span>
                            </span>
                        </a>
                        @if($reservation->hasPaymentTransactions())
                        <br/><br/>
                            <p class="text-danger"><b>Our system has detected that you already sent a payment transaction number, please double check your transaction number before proceeding for us to process your reservation correctly. Thank you!</b></p>
                        @endif
                        <br/>
                        <b class="text-uppercase text-info">newsim might ask you to upload the bank transaction slip for double checking.</b>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">undo, undo!</button>
                        <button class="btn btn-danger text-uppercase submit">continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /pay reservation -->

    <!-- /modals -->
@stop
@section('page-scripts')
    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>
    <script>
        $(function () {
            $('#payment_transactions, #history').DataTable({
                'aaSorting' : []
            });

            $("#print").click(function () {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode
                    , popClose: close
                };
                $("div.printableArea").printArea(options);
            });

            // highlight workaround start
            function removeHighlight() {
                $('#home-sidebar').removeClass('active')
            }

            setTimeout(removeHighlight, 100)
            // highlight workaround end
        });
    </script>
@stop