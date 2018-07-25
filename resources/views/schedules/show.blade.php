@extends('layouts.main')
@section('active-page')
    <li><a href="{{ route('schedules.index') }}"><b class="text-info">Schedules</b></a></li>
    <li class="active"><span class="text-muted text-uppercase">bosiet</span></li>
@stop
@section('page-short-description') {{ $branch }} @stop
@section('page-content')
    <div class="col-md-12 block3">
        <div class="white-box printableArea">
            <span class="pull-right"><b class="label label-success text-uppercase">{{ $schedule->status }}</b> </span>
            <h3 class="text-uppercase">{{ $schedule->branchCourse->details->code }} <span class="tooltip-item2"><small>{{ $schedule->branchCourse->details->description }}</small></span></h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left"> <address>
                            <h1>&nbsp;
                                <b class="text-uppercase">P {{ number_format($schedule->branchCourse->originalPrice->value, 2) }}
                                    <sup class="text-uppercase"><small>{{ $schedule->discountPercentage() }} discount</small></sup>
                                </b>
                                @if(\App\Helper\adminCan('training officer') and $schedule->branch_id == \App\Helper\admin()->branch_id) <a href="#" class="btn btn-danger text-uppercase" data-toggle="modal" data-target=".update-discount">update discount</a> @endif
                            </h1>
                            <p class="text-muted m-l-5"><b class="text-dark text-uppercase">current reservations: </b> <b>{{ $schedule->reservations->count() }}</b> <br/>
                                {{--<b class="text-warning text-uppercase">confirmed reservations: </b> <b>5</b> <br/>--}}
                                {{--<b class="text-danger text-uppercase">unconfirmed reservations: </b> <b>20</b>--}}
                            </p>
                        </address> </div>
                    <div class="pull-right text-right"> <address>
                            <p class="m-t-30"><b>Training Month and Year :</b> <i class="fa fa-calendar"></i> {{ $schedule->monthName() .' '. $schedule->year }}</p>
                            @if(\App\Helper\adminCan('training officer') and $schedule->branch_id == \App\Helper\admin()->branch_id) <p><a href="#" class="btn btn-block btn-danger text-uppercase" data-toggle="modal" data-target=".update-training-schedule">amend training schedule</a></p> @endif
                            {{--<p><b class="text-danger">Expiration Date :</b> <i class="fa fa-calendar"></i> June 1, 2018</p>--}}
                        </address> </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive" style="clear: both;">
                        <h3 class="text-uppercase"><code>timeline</code></h3>
                        <p class="text-muted">This shows important events happened to this schedule like <code class="text-uppercase">original price</code> changes and more!</p>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Event</th>
                                <th>Blame</th>
                                <th>Date Amended</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-uppercase">
                                    updated <code>original price</code> from <code>P 2,500.00</code> to <code>P 3,000.00</code>
                                </td>
                                <td class="text-uppercase">marketing officer</td>
                                <td class="text-uppercase">june 24, 2018</td>
                                <td class="text-uppercase">as per department advise</td>
                            </tr>
                            </tbody>
                        </table>
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