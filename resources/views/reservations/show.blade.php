@extends('layouts.main')
@section('active-page')
    <li><a href="{{ route('reservations.index') }}"><b class="text-info">Reservations</b></a></li>
    <li class="active"><span class="text-muted">ND-9093-22312</span></li>
@stop
@section('page-short-description') <a href="{{ route('reservations.index') . '?show_all="true"&trainee_id=1' }}" class="btn btn-info">show all reservations of esmeraldo</a> @stop
@section('page-content')
    <div class="col-md-12 block3">
        <div class="white-box printableArea">
            <h3 class="text-uppercase">reservation code:<span class="mytooltip tooltip-effect-1"> <span class="tooltip-item2">R12018-MKT001</span> <span class="tooltip-content4 clearfix"> <span class="tooltip-text2">
                            <strong>
                                R + (trainee #) + (last 4-digits = year) + <br/>
                                (first 3-letters = branch code) + <br/>
                                (last 3-digits = reservation count for current year)
                            </strong>
                        </span></span></span> <span class="pull-right"><b class="label label-success text-uppercase">new</b> </span></h3>
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
                                <th class="text-center">Transaction #</th>
                                <th class="text-center">Course</th>
                                <th>Description</th>
                                <th class="text-right">Original Price</th>
                                <th class="text-right">Discount</th>
                                <th class="text-right">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center"><a href="#" data-toggle="modal" data-target=".transaction-number-history">11232-2212-355</a></td>
                                <td class="text-center text-uppercase">bosiet</td>
                                <td>Basic Offshore Safety Induction and Emergency Training</td>
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
                    <div class="clearfix"></div>
                    <hr>
                    <div class="text-right">
                        <button class="btn btn-warning text-uppercase" data-toggle="modal" data-target=".confirm-reservation">confirm reservation</button>
                        <button class="btn btn-info text-uppercase" data-toggle="modal" data-target=".trainee-has-been-registered">trainee has been registered</button>
                        <button class="btn btn-danger text-uppercase" data-toggle="modal" data-target=".cancel-reservation">cancel reservation</button>
                        {{-- NOTE: USE IF NEED TO PRINT THIS <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modals -->

    <!-- cancel reservation -->
    <div class="modal fade cancel-reservation" tabindex="-1" role="dialog" aria-labelledby="cancelReservationLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="cancelReservationLabel">confirm action</h4> </div>
                <form action="#">
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
    <div class="modal fade confirm-reservation" tabindex="-1" role="dialog" aria-labelledby="confirmReservation" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="confirmReservation">confirm action</h4> </div>
                <form action="#">
                    <div class="modal-body">
                        Please enter the amount receive via bank transaction number # : <b>11232-2212-355</b> <br/><br/><br/>
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
    <div class="modal fade trainee-has-been-registered" tabindex="-1" role="dialog" aria-labelledby="traineeHasBeenRegistered" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="traineeHasBeenRegistered">confirm action</h4> </div>
                <div class="modal-body">
                    Are you sure trainee has already been registered? <br/><br/>
                    Please note that continuing this action <b class="text-danger text-uppercase">will send an email</b>
                    to the trainee informing him/her about his/her registration status and cannot be undone!
                </div>
                <div class="modal-footer">
                    <form action="#">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">undo, undo!</button>
                        <button class="btn btn-danger text-uppercase submit">i understand</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /trainee has been registered -->

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
<script src="{{ asset('/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
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
    });
</script>
@stop