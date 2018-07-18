@extends('layouts.main')
@section('page-specific-link') <link href="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" /> @stop
@section('active-page')
    <li><a href="{{ route('schedules.index') }}"><b class="text-info">Schedules</b></a></li>
    <li><a href="{{ route('schedules.index') . '?branch=' . $branch }}"><b class="text-info">{{ title_case($branch) }}</b></a></li>
    <li class="active"><span class="text-muted text-uppercase">{{ $schedule->branchCourse->details->code }}</span></li>
@stop
@section('page-short-description') @stop
@section('page-content')
    <div class="col-md-12 block3">
        <div class="white-box printableArea">
            <span class="pull-right"><b class="label
            @if(str_contains($schedule->status, 'new')) label-success
            @elseif(str_contains($schedule->status, 'updated')) label-warning
            @endif text-uppercase">{{ $schedule->status }}</b> </span>
            <h3 class="text-uppercase">{{ $schedule->branchCourse->details->code }} <span class="tooltip-item2"><small>{{ $schedule->branchCourse->details->description }}</small></span></h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left"> <address>
                            <h1>&nbsp;
                                <b class="text-uppercase">P {{ number_format($schedule->branchCourse->originalPrice->value, 2) }}
                                    <sup class="text-uppercase"><small>{{ $schedule->discountPercentage() }} discount</small></sup>
                                </b>
                                <a href="#" class="btn btn-danger text-uppercase" data-toggle="modal" data-target=".update-discount">update discount</a>
                            </h1>
                            <p class="text-muted m-l-5"><b class="text-dark text-uppercase">current reservations: </b> <b>25</b> <br/>
                                <b class="text-warning text-uppercase">confirmed reservations: </b> <b>5</b> <br/>
                                <b class="text-danger text-uppercase">unconfirmed reservations: </b> <b>20</b>
                            </p>
                        </address> </div>
                    <div class="pull-right text-right"> <address>
                            <p class="m-t-30"><b>Training Month and Year :</b> <i class="fa fa-calendar"></i> {{ $schedule->monthName() .' '. $schedule->year }}</p>
                            <p><a href="#" class="btn btn-block btn-danger text-uppercase" data-toggle="modal" data-target=".update-training-schedule">amend training schedule</a></p>
                            {{--<p><b class="text-danger">Expiration Date :</b> <i class="fa fa-calendar"></i> June 1, 2018</p>--}}
                        </address> </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive" style="clear: both;">
                        <h3 class="text-uppercase"><code>timeline</code></h3>
                        <p class="text-muted">This shows important events happened to this schedule like <code class="text-uppercase">original price</code> changes and more!</p>
                        <table class="table table-hover table-striped" id="history_table">
                            <thead>
                            <tr>
                                <th>Log</th>
                                <th>Remarks</th>
                                <th>Responsible</th>
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
                                        <td class="text-uppercase">{{ Carbon\Carbon::parse($history->created_at)->toFormattedDateString() }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            @if($schedule->branchCourse->originalPrice->hasHistory())
                                @foreach($schedule->branchCourse->originalPrice->history() as $history)
                                    <tr>
                                        <td class="text-uppercase">{{ $history->log }}</td>
                                        <td class="text-uppercase">{{ $history->remarks }}</td>
                                        <td class="text-uppercase">{{ $history->updatedBy->full_name }}</td>
                                        <td class="text-uppercase">{{ Carbon\Carbon::parse($history->created_at)->toFormattedDateString() }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-5 col-sm-6 col-xs-12 pull-right m-t-40">
                    <div class="panel panel-danger">
                        <div class="panel-heading"> Danger Zone
                            <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-plus"></i></a> </div>
                        </div>
                        <div class="panel-wrapper collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <p>This will <b class="text-danger text-uppercase">permanently delete this schedule and all the history above</b>. <br/><br/>
                                    This panel is <b class="text-info text-uppercase">purposely closed by default</b>, if you are reading this,
                                    and <b class="text-danger text-uppercase">still continue to delete this schedule</b>; a log will be saved tagging you
                                    as the sole administrator that is <b class="text-info text-uppercase">responsible for this deletion</b>.
                                </p>
                            </div>
                            <button class="btn btn-block btn-danger text-uppercase"  data-toggle="modal" data-target=".delete-schedule">i understand, proceed schedule deletion</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modals -->

    <!-- update schedule -->
    <div class="modal fade update-training-schedule" tabindex="-1" role="dialog" aria-labelledby="updateTrainingSchedule" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="updateTrainingSchedule">update training schedule</h4> </div>
                <form action="{{ route('schedules.update', $schedule->id) }}" method="post">
                    @csrf @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <h1 class="text-danger text-uppercase">warning!</h1>
                            <p>Updating training schedule will affect <b class="text-uppercase text-danger">all reservations</b> under it!</p>
                        </div>
                        <div class="form-group">
                            <label for="month" class="control-label">Training Month</label>
                            <select name="month" id="month" class="selectpicker form-control">
                                <option value="" class="hidden">Click to select month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <p class="text-muted text-uppercase m-t-5">select new month of training.</p>
                        </div>
                        <div class="form-group">
                            <label for="year" class="control-label">Training Year</label>
                            <input class="form-control" type="number" name="year" value="{{ \Carbon\Carbon::now()->year }}"/>
                            <p class="text-muted text-uppercase m-t-5"></p>
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="control-label">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="3" class="form-control"></textarea>
                            <p class="text-muted text-uppercase m-t-5">To be able to continue this update, please provide reason or reference for this action.</p>
                        </div>
                        <input type="number" name="updated_by" value="{{ auth()->user()->id }}" hidden>
                        <input type="number" name="schedule_id" value="{{ $schedule->id }}" hidden>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /update schedule -->

    <!-- update discount -->
    <div class="modal fade update-discount" tabindex="-1" role="dialog" aria-labelledby="updateDiscount" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="updateDiscount">update discount</h4> </div>
                <form action="{{ route('schedules.update', $schedule->id) }}" method="post">
                    @csrf @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <h1 class="text-danger text-uppercase">warning!</h1>
                            <p>Updating schedule discount <b class="text-uppercase text-danger">will not affect existing reservations</b>!</p>
                        </div>
                        <div class="form-group">
                            <label for="discount" class="control-label">Updated Discount</label>
                            <input class="form-control discount" type="text" name="discount"/>
                            <p class="text-muted text-uppercase m-t-5"></p>
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="control-label">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="3" class="form-control"></textarea>
                            <p class="text-muted text-uppercase m-t-5">To be able to continue this update, please provide reason or reference for this action.</p>
                        </div>
                        <input type="number" name="updated_by" value="{{ auth()->user()->id }}" hidden>
                        <input type="number" name="schedule_id" value="{{ $schedule->id }}" hidden>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /update discount -->

    <!-- delete schedule -->
    <div class="modal fade delete-schedule" tabindex="-1" role="dialog" aria-labelledby="deleteScheduleLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="deleteScheduleLabel">confirm action</h4> </div>
                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="post">
                    @csrf @method('delete')
                    <input type="number" name="deleted_by" value="{{ auth()->user()->administrator->id }}" hidden>
                    <input type="text" name="branch" value="{{ $schedule->branch->name }}" hidden>
                    <div class="modal-body">
                        Deleting a schedule requires <b class="text-uppercase text-info">remarks</b> for future reference. <br/><br/>
                        <textarea class="form-control form-material" name="remarks" rows="3"></textarea>
                        <a class="mytooltip pull-right" href="javascript:void(0)"> what's this?
                            <span class="tooltip-content5">
                                <span class="tooltip-text3">
                                    <span class="tooltip-inner2">To Delete, <br/> Please enter the reason why this schedule is being deleted.</span>
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
    <!-- /delete schedule -->

    <!-- /modals -->
@stop
@section('page-scripts')
    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>
    <!-- Sweet-Alert  -->
    <script src="{{ asset('/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Datatable -->
    <script src="{{ asset('/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(function () {
            $('#history_table').DataTable({
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

            $('.money-mask').mask('000.000.000.000.000,00', {reverse: true});

            // highlight workaround start
            function removeHighlight() {
                $('#home-sidebar').removeClass('active')
            }

            setTimeout(removeHighlight, 100)
            // highlight workaround end

            $('.discount').mask('000.00%', {reverse: true})

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