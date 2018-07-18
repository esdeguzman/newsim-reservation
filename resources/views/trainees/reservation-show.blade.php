@extends('layouts.trainee-main')
@section('active-page')
    <li><a href="{{ route('trainee.reservations') }}"><b class="text-info text-capitalize">reservations</b></a></li>
    <li class="active"><span class="text-muted">ND-9093-22312</span></li>
@stop
@section('page-short-description')  @stop
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
                            <h3> &nbsp;<b class="text-uppercase">Esmeraldo Barrios de Guzman Jr <sup class="text-info text-uppercase">cadet</sup></b></h3>
                            <p class="text-muted m-l-5"><b class="text-danger text-uppercase">not associated in a company</b> <br/>
                                E 104, Dharti-2, <br/>
                                Nr' Viswakarma Temple, Talaja Road, <br/>
                                Bhavnagar - 364002g <br/>
                        </address> </div>
                    <div class="pull-right text-right"> <address>
                            <p class="m-t-30"><b>Training Month :</b> <i class="fa fa-calendar"></i> December 2018</p>
                            <p><b>Reservation Date :</b> <i class="fa fa-calendar"></i> May 31, 2018</p>
                            <p><b class="text-danger">Expiration Date :</b> <i class="fa fa-calendar"></i> June 1, 2018</p>
                        </address> </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Transaction #</th>
                                <th class="text-center">Course</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-right">Original Price</th>
                                <th class="text-right">Discount</th>
                                <th class="text-right">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <a href="#" data-toggle="modal" data-target=".transaction-number-history">11232-2212-355</a>
                                    <form action="#" method="get" enctype="multipart/form-data">
                                        <input type="file" name="bank_slip" />
                                    </form>
                                </td>
                                <td class="text-center text-uppercase">bosiet</td>
                                <td>Basic Offshore Safety Induction and Emergency Training</td>
                                <td><span class="label label-success text-uppercase">approved</span></td>
                                <td class="text-right">P 3,000.00</td>
                                <td class="text-right">50%</td>
                                <td class="text-right">P 1,500.00</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-right m-t-30 text-right">
                        <hr>
                        <h3><b>Total :</b> P 1,500.00</h3> </div>
                    <div class="m-t-30">
                        <br/><br/><br/><br/>
                        <p class="text-muted">Confirmed by: <b class="text-uppercase text-info">accounting officer</b></p>
                        <p class="text-muted">Registered by: <b class="text-uppercase text-info">registration officer</b></p>
                        <p class="text-muted">Remarks: <b class="text-uppercase">none</b></p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr>
                <div class="text-right">
                    <button class="btn btn-warning text-uppercase" data-toggle="modal" data-target=".confirm-payment">confirm payment</button>
                    <button class="btn btn-danger text-uppercase" data-toggle="modal" data-target=".cancel-reservation">cancel reservation</button>
                    {{-- NOTE: USE IF NEED TO PRINT THIS <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>--}}
                </div>
            </div>
        </div>
    </div>

    <!-- modals -->

    <!-- cancel reservation -->
    <div class="modal fade cancel-reservation" tabindex="-1" role="dialog" aria-labelledby="cancelReservationLabel" aria-hidden="true" style="display: none;">
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
    <div class="modal fade confirm-payment" tabindex="-1" role="dialog" aria-labelledby="confirmPaymentLabel" aria-hidden="true" style="display: none;">
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
                        <br/><br/>
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
    <!-- /confirm reservation -->

    <!-- transaction number history -->
    <div class="modal fade transaction-number-history" tabindex="-1" role="dialog" aria-labelledby="transactionNumberHistory" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="transactionNumberHistory">History</h4> </div>
                <div class="modal-body">
                    <ul class="timeline">
                        <li>
                            <div class="timeline-badge danger"><b>23</b></div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 class="timeline-title">11232-2212-355</h4>
                                    <p><small class="text-muted"><i class="fa fa-clock-o"></i> May 31, 2018</small></p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /transaction number history -->

    <!-- /modals -->
@stop
@section('page-scripts')
    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>
    <!-- Sweet-Alert  -->
    <script src="{{ asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(function () {
            $("#print").click(function () {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode
                    , popClose: close
                };
                $("div.printableArea").printArea(options);
            });

            $('.money-mask').mask('000.000.000.000.000,00', {reverse: true});

            // highlight workaround start
            function removeHighlight() {
                $('#home-sidebar').removeClass('active')
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
        });
    </script>
@stop