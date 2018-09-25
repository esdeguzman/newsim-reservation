@extends('layouts.trainee-main')
@section('active-page')
    <li><a href="{{ route('trainee-schedules') }}"><b class="text-info">Schedules</b></a></li>
    <li class="active"><span class="text-muted text-uppercase">{{ $schedule->branchCourse->details->code }}</span></li>
@stop
@section('page-short-description') {{ $schedule->branchCourse->branch->name }} @stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box printableArea">
            <span class="pull-right"><b class="label
            @if($schedule->status == 'new' or $schedule->status == 're-opened') label-success
            @elseif($schedule->status == 'updated') label-warning
            @elseif($schedule->status == 'closed') label-primary
            @endif text-uppercase">{{ $schedule->status }}</b> </span>
            <h3 class="text-uppercase">{{ $schedule->branchCourse->details->code }} <span class="tooltip-item2"><small>{{ $schedule->branchCourse->details->description }}</small></span></h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left"> <address>
                            <h1> &nbsp;<b class="text-uppercase">P {{ number_format($schedule->branchCourse->originalPrice->value, 2) }} <sup class="text-uppercase"><small>{{ $schedule->discountPercentage() }} discount</small></sup></b>&#8594;&nbsp;&nbsp;
                                @if($schedule->isFull())
                                <b class="text-uppercase text-danger">full</b>
                                @else
                                <button class="btn btn-info text-uppercase" type="button" data-toggle="modal" data-target=".confirm-reservation">reserve for only P {{ number_format($schedule->branchCourse->originalPrice->value * $schedule->discount, 2) }}</button>
                                @endif
                            </h1>
                            <p class="text-muted m-l-5"><b class="text-dark text-uppercase">available slots: </b> <b>{{ optional($schedule->paidReservations())->count() + \App\Helper\addedWalkinApplicants($schedule->batch) }} / {{ $schedule->batch->capacity }}</b> <br/>
                        </address> </div>
                    <div class="pull-right text-right"> <address>
                            <p class="m-t-30"><b>Training schedule :</b> <i class="fa fa-calendar"></i> {{ $schedule->monthName() .' '. $schedule->year }}: Batch {{ $schedule->batch->number .' - '. strtoupper($schedule->batch->day_part) }}</p>
                            <p><b>AM :</b> <i class="fa fa-clock-o"></i> 6:00am - 2:00pm</p>
                            <p><b>PM :</b> <i class="fa fa-clock-o"></i> 2:00pm - 10:00pm</p>
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
                                <th>Log</th>
                                <th>Remarks</th>
                                <th>Blame</th>
                                <th>Date Amended</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($schedule->hasHistory())
                                @foreach($schedule->history() as $history)
                                <tr>
                                    <td class="text-uppercase">{{ $history->log }}</td>
                                    <td class="text-uppercase">{{ $history->remarks }}</td>
                                    <td class="text-uppercase">{{ $history->updatedBy->full_name }}</td>
                                    <td class="text-uppercase">{{ Carbon\Carbon::parse($history->created_by)->toFormattedDateString() }}</td>
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

    @if($schedule->isFull() === false)
    <!-- confirm course reservation -->
    <div class="modal fade confirm-reservation block3" tabindex="-1" role="dialog" aria-labelledby="confirmReservationLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="confirmReservationLabel">confirm action</h4> </div>
                <form action="{{ route('trainee-reservations.store', $schedule->id) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        Are you sure you want to reserve this course? <br/><br/>
                        Please note that continuing this action <b class="text-danger text-uppercase">will reserve this course to your account</b>,
                        also please bear in mind that a reservation will <b class="text-danger text-uppercase">only be active for 24hrs after it has been reserved</b>
                        failure to pay within this time-frame will <b class="text-danger text-uppercase">automatically cancel your reservation</b><br/><br/>
                        <div class="checkbox checkbox-success">
                            <input id="reserve-course" type="checkbox" name="confirmation">
                            <label for="reserve-course"> Yep! Let me reserve a slot for this course. </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button class="btn btn-info text-uppercase" data-dismiss="modal">undo, undo!</button>
                            <button class="btn btn-danger text-uppercase submit">continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /confirm course reservation -->
    @endif

    <!-- /modals -->
@stop
@section('page-scripts')
    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>
    <!-- Sweet-Alert  -->
    <script src="{{ asset('/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
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

            $('.table').dataTable({
                'aaSorting' : []
            });

            $('.money-mask').mask('000.000.000.000.000,00', {reverse: true});

            // highlight workaround start
            function removeHighlight() {
                $('#home-sidebar').removeClass('active')
            }

            setTimeout(removeHighlight, 100)
            // highlight workaround end
        });
    </script>
@stop