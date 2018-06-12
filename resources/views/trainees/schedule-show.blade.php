@extends('layouts.trainee-main')
@section('active-page')
    <li><a href="{{ route('trainee.schedules') }}"><b class="text-info">Schedules</b></a></li>
    <li class="active"><span class="text-muted text-uppercase">bosiet</span></li>
@stop
@section('page-short-description') makati @stop
@section('page-content')
    <div class="col-md-12 block3">
        <div class="white-box printableArea">
            <span class="pull-right"><b class="label label-success text-uppercase">new</b> </span>
            <h3 class="text-uppercase">bosiet <span class="tooltip-item2"><small>basic offshore safety induction and emergency training</small></span></h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left"> <address>
                            <h1> &nbsp;<b class="text-uppercase">P 3,000.00 <sup class="text-uppercase"><small>50% discount</small></sup></b>&#8594;&nbsp;&nbsp;
                                <button class="btn btn-info text-uppercase" type="button" data-toggle="modal" data-target=".confirm-reservation">reserve for only P 1,500.00</button>
                            </h1>
                        </address> </div>
                    <div class="pull-right text-right"> <address>
                            <p class="m-t-30"><b>Training Month :</b> <i class="fa fa-calendar"></i> December 2018</p>
                            {{--<p><b>Reservation Date :</b> <i class="fa fa-calendar"></i> May 31, 2018</p>--}}
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

    <!-- trainee has been registered -->
    <div class="modal fade confirm-reservation" tabindex="-1" role="dialog" aria-labelledby="confirmReservationLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="confirmReservationLabel">confirm action</h4> </div>
                <div class="modal-body">
                    Are you sure you want to reserve this course? <br/><br/>
                    Please note that continuing this action <b class="text-danger text-uppercase">will reserve this course to your account</b>,
                    also please bear in mind that a reservation will <b class="text-danger text-uppercase">only be active for 24hrs after it has been reserved</b>
                    failure to pay within this time-frame will <b class="text-danger text-uppercase">automatically cancel your reservation</b><br/><br/>
                    <div class="checkbox checkbox-success">
                        <input id="reserve-course" type="checkbox">
                        <label for="reserve-course"> Yep! Let me reserve a slot for this course. </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="#">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">undo, undo!</button>
                        <button class="btn btn-danger text-uppercase submit">continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /trainee has been registered -->

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