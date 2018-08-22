@extends('layouts.main')
@section('active-page')
    <li><a href="{{ route('reservations.index') }}"><b class="text-info">Reservations</b></a></li>
    <li class="active"><span class="text-muted">{{ $reservation->code }}</span></li>
@stop
@section('page-short-description') <a href="{{ route('reservations.index') . '?trainee=' . $reservation->trainee_id }}" class="btn btn-info">show all reservations of {{ $reservation->trainee->fullName() }}</a> @stop
@section('page-content')
    <div class="col-md-12 block3">
        <div class="white-box printableArea">
            <h3 class="text-uppercase">
                <span class="pull-right">
                    <b class="label
                    @if($reservation->status == 'new') label-success
                    @elseif($reservation->status == 'cancelled' || $reservation->status == 'expired') label-danger
                    @elseif($reservation->status == 'paid' || $reservation->status == 'registered' || $reservation->status == 'refunded') label-info
                    @elseif($reservation->status == 'pending' || $reservation->status == 'overpaid' || $reservation->status == 'underpaid') label-warning
                    @endif
                    text-uppercase">{{ $reservation->status }}</b>
                </span>
                reservation code:<span class="mytooltip tooltip-effect-1"> <span class="tooltip-item2">{{ $reservation->code }}</span> <span class="tooltip-content4 clearfix"> <span class="tooltip-text2">
                    <strong>
                        R + (trainee #) + (last 4-digits = year) + <br/>
                        (first 3-letters = branch code) + <br/>
                        (last 4-digits = reservation count for current year)
                    </strong>
                </span></span></span>
                @if($reservation->cor_number)<br/>cor#: <b class="text-info">{{ $reservation->cor_number }}</b>@endif
            </h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">
                        <address>
                            <h3> &nbsp;<b class="text-uppercase">{{ $reservation->trainee->fullName() }} <sup class="text-info text-uppercase">{{ $reservation->trainee->rank }}</sup></b></h3>
                            <p class="text-muted m-l-5"><b class="text-danger text-uppercase">
                                @if($reservation->trainee->company) {{ $reservation->trainee->company }}
                                @else not associated in a company
                                @endif</b> <br/>
                                Address: {{ $reservation->trainee->address }} <br/>
                                Born: {{ \App\Helper\toReadableDate($reservation->trainee->birth_date) }} <br/>
                        </address> </div>
                    <div class="pull-right text-right"> <address>
                            <p class="m-t-30"><b>Training Month :</b> <i class="fa fa-calendar"></i> {{ $reservation->schedule->monthName() }} {{ $reservation->schedule->year }}</p>
                            <p><b>Reservation Date :</b> <i class="fa fa-calendar"></i> {{ \App\Helper\toReadableDate($reservation->created_at) }}</p>
                            <p><b class="text-danger">Expiration Date :</b> <i class="fa fa-calendar"></i> {{ \App\Helper\toReadableExpirationDate($reservation->created_at) }}</p>
                        </address>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive m-t-40">
                        <table class="table table-hover" id="payment_transactions">
                            <thead>
                            <tr>
                                <th>Transaction #</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Original Price</th>
                                <th class="text-center">Discount</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">Received</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($reservation->hasPaymentTransactions())
                                @foreach($reservation->paymentTransactions->sortByDesc('created_at') as $paymentTransaction)
                                    <tr>
                                        <td>{{ $paymentTransaction->number }}</td>
                                        <td class="text-center text-uppercase">{{ $paymentTransaction->type }}</td>
                                        <td class="text-center"><span class="label label-success text-uppercase">{{ $paymentTransaction->status }}</span></td>
                                        <td class="text-right">P {{ number_format($paymentTransaction->reservation->original_price, 2) }}</td>
                                        <td class="text-center">{{ \App\Helper\toPercentage($paymentTransaction->reservation->discount) }}</td>
                                        <td class="text-right">P {{ \App\Helper\toReadablePayment($paymentTransaction->reservation->original_price, $paymentTransaction->reservation->discount) }}</td>
                                        <td class="text-right">P {{ number_format($paymentTransaction->received_amount, 2) }}</td>
                                        <td class="text-center">
                                            @if((auth()->user()->isDev() || \App\Helper\adminCan('confirm reservation') or \App\Helper\adminCan('accounting officer')) && $paymentTransaction->status == 'new')
                                                <button class="btn btn-warning text-uppercase" data-toggle="modal" data-target=".confirm-reservation" type="button" data-transaction-number="{{ $paymentTransaction->number }}" id="confirmReservation">confirm reservation</button>
                                            @else <span class="text-uppercase text-muted">no actions needed</span>
                                            @endif
                                        </td>
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
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="text-right">
                    @if((auth()->user()->isDev() || \App\Helper\adminCan('refund excess payment') or \App\Helper\adminCan('accounting officer') && \App\Helper\admin()->branch->id == $reservation->branch_id) && $reservation->isPaidOrExpiredButCancelled())<button class="btn btn-warning text-uppercase" data-toggle="modal" data-target=".refund-excess-payment">refund excess payment</button> @endif
                    @if((auth()->user()->isDev() || \App\Helper\adminCan('refund excess payment') or \App\Helper\adminCan('accounting officer') && \App\Helper\admin()->branch->id == $reservation->branch_id) && ($reservation->hasRefund() && $reservation->hasExcessPayment()))<button class="btn btn-warning text-uppercase" data-toggle="modal" data-target=".refund-excess-payment">refund excess payment</button> @endif
                    @if((auth()->user()->isDev() || \App\Helper\adminCan('receive payment on-site') or \App\Helper\adminCan('accounting officer') && \App\Helper\admin()->branch->id == $reservation->branch_id) && ($reservation->receive_payment || $reservation->status == 'underpaid'))<button class="btn btn-success text-uppercase" data-toggle="modal" data-target=".receive-payment">receive payment on-site</button> @endif
                    @if((auth()->user()->isDev() || \App\Helper\adminCan('confirm registration') or \App\Helper\adminCan('registration officer') && \App\Helper\admin()->branch->id == $reservation->branch_id) && ($reservation->status == 'paid' || $reservation->status == 'overpaid' || $reservation->status == 'refunded'))<button class="btn btn-info text-uppercase" data-toggle="modal" data-target=".trainee-has-been-registered">trainee has been registered</button> @endif
                    @if((auth()->user()->isDev() || \App\Helper\adminCan('cancel reservation') or \App\Helper\adminCan('accounting officer') && \App\Helper\admin()->branch->id == $reservation->branch_id) && $reservation->status != 'cancelled')<button class="btn btn-danger text-uppercase" data-toggle="modal" data-target=".cancel-reservation">cancel reservation</button> @endif
                    {{-- NOTE: USE IF NEED TO PRINT THIS <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>--}}
                </div>
                <div class="clearfix"></div>
                <hr>
                    <div class="col-md-12">
                        <h3 class="text-uppercase"><b>reservation history</b></h3>
                        <div class="table-responsive m-t-40" style="clear: both;">
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
    </div>

    <!-- modals -->

    <!-- cancel reservation -->
    <div class="modal fade cancel-reservation block3" tabindex="-1" role="dialog" aria-labelledby="cancelReservationLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="cancelReservationLabel">confirm action</h4> </div>
                <form action="{{ \App\Helper\prefixedUrl() . "/reservations/$reservation->id" }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        Cancelling a reservation requires <b class="text-uppercase text-info">remarks</b> for future reference. <br/><br/><br/>
                        <textarea class="form-control form-material" name="remarks" rows="3"></textarea>
                        <a class="mytooltip pull-right" href="javascript:void(0)"> what's this?
                            <span class="tooltip-content5">
                                <span class="tooltip-text3">
                                    <span class="tooltip-inner2">To Cancel, <br/> Please enter the reason why this reservation is being cancelled.</span>
                                </span>
                            </span>
                        </a>
                        <br/>
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

    <!-- confirm reservation -->
    <div class="modal fade confirm-reservation block3" tabindex="-1" role="dialog" aria-labelledby="confirmReservation" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="confirmReservation">confirm action</h4> </div>
                <form action="{{ route('reservations.confirm', $reservation->id) }}" method="post">
                    @csrf
                    @method('put')
                    <input type="text" name="number" id="number" hidden>
                    <div class="modal-body">
                        Please enter the amount receive via bank transaction number # : <b id="transactionNumber">11232-2212-355</b> <br/><br/><br/>
                        <input type="text" class="form-control form-material money-mask" name="amount">
                        <a class="mytooltip pull-right" href="javascript:void(0)"> what's this?
                            <span class="tooltip-content5">
                                <span class="tooltip-text3">
                                    <span class="tooltip-inner2">To Confirm, <br/> Please enter the exact amount received via indicated bank transaction number.</span>
                                </span>
                            </span>
                        </a>
                        <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">what amount?!</button>
                        <button class="btn btn-danger text-uppercase submit">continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /confirm reservation -->

    <!-- trainee has been registered -->
    <div class="modal fade trainee-has-been-registered block3" tabindex="-1" role="dialog" aria-labelledby="traineeHasBeenRegistered" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="traineeHasBeenRegistered">confirm action</h4> </div>
                <form action="{{ route('reservations.registered', $reservation->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        Are you sure trainee has already been registered? Please provide the COR# below <br/><br/>
                        <input name="cor_number" class="form-control" placeholder="Certificate Of Registration Number from TMS" /> <br/><br/>
                        Note that continuing this action <b class="text-danger text-uppercase">will send an email</b>
                        to the trainee informing him/her about his/her registration status and cannot be undone!<br/><br/>
                        This action will be tagged to <b class="text-info">{{ \App\Helper\admin()->full_name }}</b>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal" type="button">undo, undo!</button>
                        <button class="btn btn-danger text-uppercase submit">i understand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /trainee has been registered -->

    <!-- refund excess payment -->
    <div class="modal fade refund-excess-payment block3" tabindex="-1" role="dialog" aria-labelledby="refundExcessPaymentLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="refundExcessPaymentLabel">confirm action</h4> </div>
                <form action="{{ route('reservations.refund', $reservation->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        You are about to refund excess payment to the trainee.<br/> Please enter the amount to be refunded. <br/><br/>
                        <input name="amount" class="form-control money-mask" placeholder="Amount to be refunded" /> <br/>
                        This action will be tagged to <b class="text-info">{{ \App\Helper\admin()->full_name }}</b>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal" type="button">undo, undo!</button>
                        <button class="btn btn-danger text-uppercase submit">i understand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /refund excess payment -->

    <!-- pay reservation -->
    <div class="modal fade receive-payment block3" tabindex="-1" role="dialog" aria-labelledby="receivePaymentLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="receivePaymentLabel">confirm action</h4> </div>
                <form action="{{ \App\Helper\prefixedUrl() . '/payment-transactions' }}" method="post">
                    @csrf
                    <input type="text" name="reservation_id" value="{{ $reservation->id }}" hidden />
                    <div class="modal-body">
                        Please enter the receipt number # <br/><br/>
                        <input type="text" class="form-control form-material" name="number" placeholder="Payment Receipt number">
                        @if($errors->has('amount')) <b class="text-danger">{{ $errors->first('amount') }}</b>
                        @else
                        <a class="mytooltip pull-right" href="javascript:void(0)"> what's this?
                            <span class="tooltip-content5">
                                <span class="tooltip-text3">
                                    <span class="tooltip-inner2">To Confirm, <br/> Please enter the exact receipt number.</span>
                                </span>
                            </span>
                        </a>
                        @endif
                        <br/><br/><br/>
                        Please enter the exact amount paid based on the receipt <br/><br/>
                        <input type="text" class="form-control form-material money-mask" name="amount" placeholder="Amount paid by trainee" />
                        @if($errors->has('amount')) <p class="text-danger"> <b>{{ $errors->first('amount') }}</b>
                        @else <p class="text-muted"> If your account is also allowed to confirm trainee reservations, continuing this action will also confirm the reservation.
                        @endif
                        </p>
                        @if($reservation->hasPaymentTransactions())
                            <br/><br/>
                            <textarea name="remarks" rows="3" class="form-control" placeholder="Please write your reason here."></textarea>
                            <p class="text-muted">Our system has detected that trainee already sent a payment transaction number/s, please enter the reason why are you sending another one. This will be help us to control vulgar acts such as spamming. Thank you!</p>
                        @endif
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
        $('#payment_transactions').dataTable({
            'aaSorting': []
        })

        $('#history').dataTable({
            'aaSorting': []
        })

        $("#print").click(function () {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode
                , popClose: close
            };
            $("div.printableArea").printArea(options);
        });

        $('.money-mask').mask('000,000,000,000,000.00', {reverse: true});

        // highlight workaround start
        function removeHighlight() {
            $('#home-sidebar').removeClass('active')
            $('#schedules-sidebar').removeClass('active')
        }

        setTimeout(removeHighlight, 100)
        // highlight workaround end

        $('.submit').click(function () {
            $('div.block3').block({
                message: '<h3>Please Wait...</h3>'
                , overlayCSS: {
                    backgroundColor: '#02bec9'
                }
                , css: {
                    border: '1px solid #fff'
                }
            });
        });

        $('#confirmReservation').on('click', function () {
            $('#number').val($(this).data('transaction-number'))
            $('#transactionNumber').text($(this).data('transaction-number'))
        });
    });
</script>
@stop