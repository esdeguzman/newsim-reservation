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
            @if($schedule->status == 'new' or $schedule->status == 're-opened') label-success
            @elseif($schedule->status == 'updated') label-warning
            @elseif($schedule->status == 'closed') label-primary
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
                                @if(\App\Helper\adminCan('training officer') and $schedule->branch_id == \App\Helper\admin()->branch_id) <a href="#" class="btn btn-danger text-uppercase" data-toggle="modal" data-target=".update-discount">update discount</a> @endif
                            </h1>
                            <p class="text-muted m-l-5"><b class="text-dark text-uppercase">available slots: </b> <b>{{ optional($schedule->paidReservations())->count() + \App\Helper\addedWalkinApplicants($schedule->batch) }} / {{ $schedule->batch->capacity }}</b> &nbsp;
                                <a href="#" class="text-uppercase btn btn-xs btn-primary" data-toggle="modal" data-target=".adjust-available-slots"><b>Adjust available slots</b></a> <br/>
                                {{--<b class="text-warning text-uppercase">confirmed reservations: </b> <b>5</b> <br/>--}}
                                {{--<b class="text-danger text-uppercase">unconfirmed reservations: </b> <b>20</b>--}}
                            </p>
                        </address> </div>
                    <div class="pull-right text-right"> <address>
                            <p class="m-t-30"><b>Training schedule :</b> <i class="fa fa-calendar"></i> {{ $schedule->monthName() }} {{ \Carbon\Carbon::parse($schedule->batch->start_date)->day }} - {{ \Carbon\Carbon::parse($schedule->batch->end_date)->day }}, {{ $schedule->year }}: Batch {{ $schedule->batch->number .' - '. strtoupper($schedule->batch->day_part) }}</p>
                            <p><b>AM :</b> <i class="fa fa-clock-o"></i> 6:00am - 2:00pm</p>
                            <p><b>PM :</b> <i class="fa fa-clock-o"></i> 2:00pm - 10:00pm</p>
                            @if(\App\Helper\adminCan('training officer') and $schedule->branch_id == \App\Helper\admin()->branch_id) <p><a href="#" class="btn btn-block btn-warning text-uppercase" data-toggle="modal" data-target=".update-training-schedule">amend training schedule</a></p> @endif
                            @if(\App\Helper\adminCan('registration officer') and $schedule->branch_id == \App\Helper\admin()->branch_id and $schedule->status != 'closed') <p><a href="#" class="btn btn-block btn-danger text-uppercase" data-toggle="modal" data-target=".close-schedule">close training schedule</a></p> @endif
                            @if(\App\Helper\adminCan('registration officer') and $schedule->branch_id == \App\Helper\admin()->branch_id and $schedule->status == 'closed') <p><a href="#" class="btn btn-block btn-primary text-uppercase" data-toggle="modal" data-target=".re-open-schedule">re-open training schedule</a></p> @endif
                        </address> </div>
                </div>
                <div class="col-md-12">
                    <h3 class="text-uppercase"><code>registered trainees under this schedule</code></h3>
                    <ul class="list-unstyled m-b-20">
                        <li class="text-uppercase m-b-10 m-t-20"><b>added walk-in applicants</b></li>
                        @if($schedule->hasWalkinApplicants())
                            @foreach($schedule->batch->corNumbers() as $corNumber)
                            <li class="text-uppercase"><i class="fa fa-user-plus"></i> {{ $corNumber }}</li>
                            @endforeach
                        @else <li class="text-uppercase">none</li>
                        @endif
                        <li class="text-uppercase m-b-10 m-t-10"><b>from system reservations</b></li>
                        @if($schedule->hasReservations())
                            @foreach($schedule->reservations as $reservation)
                            <li class="text-uppercase"><i class="fa fa-tags"></i> {{ $reservation->code }}</li>
                            @endforeach
                        @else <li class="text-uppercase">none</li>
                        @endif
                        <li class="m-t-20"><button class="btn btn-info text-uppercase" data-toggle="modal" data-target=".move-trainee">move walk-in applicant/reservation to other batch</button></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive" style="clear: both;">
                        <h3 class="text-uppercase"><code>timeline</code></h3>
                        <p class="text-muted">This shows important events happened to this schedule like <code class="text-uppercase">standard price</code> changes and more!</p>
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
                @if(\App\Helper\adminCan('training officer'))
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
                @endif
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
                                <option value="1" {{ $schedule->month == '1'? 'selected' : '' }}>January</option>
                                <option value="2" {{ $schedule->month == '2'? 'selected' : '' }}>February</option>
                                <option value="3" {{ $schedule->month == '3'? 'selected' : '' }}>March</option>
                                <option value="4" {{ $schedule->month == '4'? 'selected' : '' }}>April</option>
                                <option value="5" {{ $schedule->month == '5'? 'selected' : '' }}>May</option>
                                <option value="6" {{ $schedule->month == '6'? 'selected' : '' }}>June</option>
                                <option value="7" {{ $schedule->month == '7'? 'selected' : '' }}>July</option>
                                <option value="8" {{ $schedule->month == '8'? 'selected' : '' }}>August</option>
                                <option value="9" {{ $schedule->month == '9'? 'selected' : '' }}>September</option>
                                <option value="10" {{ $schedule->month == '10'? 'selected' : '' }}>October</option>
                                <option value="11" {{ $schedule->month == '11'? 'selected' : '' }}>November</option>
                                <option value="12" {{ $schedule->month == '12'? 'selected' : '' }}>December</option>
                            </select>
                            @if($errors->has('remarks')) <p class="text-danger text-uppercase m-t-5">{{ $errors->first('remarks') }}</p>
                            @else <p class="text-muted text-uppercase m-t-5">select new month of training.</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="capacity" class="control-label">Training Start Date</label>
                            <input class="form-control" type="date" name="start_date" value="{{ old('start_date') }}"/>
                            <p class="text-muted text-uppercase m-t-5">Set this schedule's start day i.e. 25</p>
                        </div>
                        <div class="form-group">
                            <label for="capacity" class="control-label">Training End Date</label>
                            <input class="form-control" type="date" name="end_date" value="{{ old('end_date') }}"/>
                            <p class="text-muted text-uppercase m-t-5">Set this schedule's end day i.e. 31</p>
                        </div>
                        <div class="form-group">
                            <label for="day_part" class="control-label">Training Day Part</label>
                            <select name="day_part" id="day_part" class="selectpicker form-control">
                                <option value="" class="hidden">Click to select day part</option>
                                <option value="am" {{ $schedule->batch->day_part == 'am'? 'selected' : '' }}>AM</option>
                                <option value="pm" {{ $schedule->batch->day_part == 'pm'? 'selected' : '' }}>PM</option>
                            </select>
                            @if($errors->has('remarks')) <p class="text-danger text-uppercase m-t-5">{{ $errors->first('remarks') }}</p>
                            @else <p class="text-muted text-uppercase m-t-5">select which day part the class will be conducted.</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="capacity" class="control-label">Training Capacity</label>
                            <input class="form-control" type="number" name="capacity" value="{{ $schedule->batch->capacity }}"/>
                            @if($errors->has('remarks')) <p class="text-danger text-uppercase m-t-5">{{ $errors->first('remarks') }}</p>
                            @else <p class="text-muted text-uppercase m-t-5">Set this schedule's max trainee capacity</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="year" class="control-label">Training Year</label>
                            <input class="form-control" type="number" name="year" value="{{ \Carbon\Carbon::now()->year }}"/>
                            <p class="text-danger text-uppercase m-t-5">{{ $errors->first('year') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="control-label">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="3" class="form-control"></textarea>
                            @if($errors->has('remarks')) <p class="text-danger text-uppercase m-t-5">{{ $errors->first('remarks') }}</p>
                            @else <p class="text-muted text-uppercase m-t-5">To be able to continue this update, please provide reason or reference for this action.</p>
                            @endif
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

    <!-- close schedule -->
    <div class="modal fade close-schedule" tabindex="-1" role="dialog" aria-labelledby="closeScheduleLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="closeScheduleLabel">confirm action</h4> </div>
                <form action="{{ route('schedules.close', $schedule->id) }}" method="post">
                    @csrf @method('put')
                    <div class="modal-body">
                        Closing a schedule requires <b class="text-uppercase text-info">remarks</b> for future reference. <br/><br/>
                        <textarea class="form-control form-material" name="remarks" rows="3"></textarea>
                        <a class="mytooltip pull-right" href="javascript:void(0)"> what's this?
                            <span class="tooltip-content5">
                                <span class="tooltip-text3">
                                    <span class="tooltip-inner2">To Close, <br/> Please enter the reason why this schedule is being closed.</span>
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
    <!-- /close schedule -->

    <!-- re-open schedule -->
    <div class="modal fade re-open-schedule" tabindex="-1" role="dialog" aria-labelledby="reOpenScheduleLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="reOpenScheduleLabel">confirm action</h4> </div>
                <form action="{{ route('schedules.re-open', $schedule->id) }}" method="post">
                    @csrf @method('put')
                    <div class="modal-body">
                        Closing a schedule requires <b class="text-uppercase text-info">remarks</b> for future reference. <br/><br/>
                        <textarea class="form-control form-material" name="remarks" rows="3"></textarea>
                        <a class="mytooltip pull-right" href="javascript:void(0)"> what's this?
                            <span class="tooltip-content5">
                                <span class="tooltip-text3">
                                    <span class="tooltip-inner2">To Re-open, <br/> Please enter the reason why this schedule is being re-opened.</span>
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
    <!-- /re-open schedule -->

    <!-- adjust available slots -->
    <div class="modal fade adjust-available-slots" tabindex="-1" role="dialog" aria-labelledby="adjustAvailableSlots" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="adjustAvailableSlots">adjust available slots</h4> </div>
                <form action="{{ route('batches.update', $schedule->batch->id) }}" method="post">
                    @csrf @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <h1 class="text-danger text-uppercase">warning!</h1>
                            <p>Adjusting available slots may result to capacity overflow!</p>
                        </div>
                        <div class="form-group">
                            <p >Please select adjusting process below: <br></p>
                            <input type="radio" name="adjusting_process" id="add_registered_walkins" class="radio radio-inline" value="add_registered_walkins">
                            <label for="add_registered_walkins" class="control-label">Add registered walk-in applicants</label>
                            <textarea name="cor_numbers" rows="3" class="form-control" style="display: none" id="cor_numbers">{{ $schedule->batch->cor_numbers }}</textarea>
                            @if($errors->has('cor_numbers')) <p class="text-danger text-uppercase m-t-5">{{ $errors->first('cor_numbers') }}</p>
                            @else <p class="text-muted text-uppercase m-t-5" style="display: none" id="cor_numbers_info">To be able to continue this update, please provide COR number/s. Use this format for multiple entries: COR#1,COR#2,COR#3</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="radio" name="adjusting_process" id="adjust_maximum_capacity" classsd="radio radio-inline" value="adjust_maximum_capacity">
                            <label for="adjust_maximum_capacity" class="control-label">Adjust maximum slot capacity</label>
                            <input type="number" name="capacity" value="{{ old('capacity') }}" class="form-control" style="display: none">
                            @if($errors->has('capacity')) <p class="text-danger text-uppercase m-t-5">{{ $errors->first('capacity') }}</p>
                            @else <p class="text-muted text-uppercase m-t-5" style="display: none" id="capacity_info">Please enter the new <b class="text-uppercase">maximum slot</b> for this schedule. Current maximum slot is: <b>{{ $schedule->batch->capacity }}</b></p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="control-label">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="3" class="form-control">{{ old('remarks') }}</textarea>
                            @if($errors->has('remarks')) <p class="text-danger text-uppercase m-t-5">{{ $errors->first('remarks') }}</p>
                            @else <p class="text-muted text-uppercase m-t-5">To be able to continue this update, please provide reason or reference for this action.</p>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /adjust available slots -->

    <!-- move trainee -->
    <div class="modal fade move-trainee" tabindex="-1" role="dialog" aria-labelledby="moveTrainee" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="moveTrainee">move trainee to other batch</h4> </div>
                <form action="{{ route('schedules.move-trainee', $schedule->id) }}" method="post">
                    @csrf @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <h1 class="text-danger text-uppercase">warning!</h1>
                            <p>Adjusting available slots may result to capacity overflow!</p>
                        </div>
                        <div class="form-group">
                            <label for="move">Select COR# or Reservation Code to be moved</label>
                            <select class="form-control" name="move">
                                <option value="">Empty selection</option>
                                @if($schedule->hasReservations())
                                    @foreach($schedule->reservations as $reservation)
                                    <option>{{ $reservation->code }}</option>
                                    @endforeach
                                @endif
                                @if($schedule->hasWalkinApplicants())
                                    @foreach($schedule->batch->corNumbers() as $corNumber)
                                    <option>{{ $corNumber }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if($errors->has('move')) <p class="text-danger text-uppercase m-t-5">{{ $errors->first('move') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="batch_id">Select new batch for the selection above</label>
                            <select class="form-control" name="batch_id">
                                <option value="">Empty selection</option>
                                @foreach($schedule->batches() as $batch)
                                <option {{ ($batch->id === $schedule->batch->id or $batch->schedule->isFull())? 'disabled' : '' }} value="{{ $batch->id }}">{{ $batch->schedule->branchCourse->details->code }} - {{ $batch->schedule->monthName() }} {{ \Carbon\Carbon::parse($batch->start_date)->day }} - {{ \Carbon\Carbon::parse($batch->end_date)->day }}, {{ $batch->schedule->year }}: Batch {{ $batch->schedule->number .' - '. strtoupper($batch->day_part) }} {{ $batch->id === $schedule->batch->id? '(CURRENT)' : '' }}  {{ $batch->schedule->isFull()? '(FULL)' : '' }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('batch_id')) <p class="text-danger text-uppercase m-t-5">{{ $errors->first('batch_id') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="control-label">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="3" class="form-control">{{ old('remarks') }}</textarea>
                            @if($errors->has('remarks')) <p class="text-danger text-uppercase m-t-5">{{ $errors->first('remarks') }}</p>
                            @else <p class="text-muted text-uppercase m-t-5">To be able to continue this update, please provide reason or reference for this action.</p>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /move trainee -->

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

            $('#add_registered_walkins').on('click', function () {
                $('textarea[name="cor_numbers"]').show()
                $('#cor_numbers_info').show()
                $('input[name="capacity"]').hide()
                $('#capacity_info').hide()
            })

            $('#adjust_maximum_capacity').on('click', function () {
                $('textarea[name="cor_numbers"]').hide()
                $('#cor_numbers_info').hide()
                $('input[name="capacity"]').show()
                $('#capacity_info').show()
            })

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

        $('#cor_numbers').on('keyup', function () {
            $(this).val($(this).val().toLowerCase())
        });
    </script>
@stop