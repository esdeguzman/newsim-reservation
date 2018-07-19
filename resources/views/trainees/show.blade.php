@extends('layouts.main')
@section('page-tab-title') Courses @stop
@section('page-specific-link') <link rel="stylesheet" type="text/css" href="{{ asset('multiselect/css/multi-select.css') }}"> @stop
@section('active-page')
    <li class="active"><a href="{{ route('trainees.index') }}">Trainees</a></li>
    <li>{{ $trainee->fullName() }}</li>
@stop
@section('administrators-sidebar-menu') active @stop
@section('page-short-description') <a href="{{ route('reservations.index') . "?trainee_id={$trainee->id}" }}" class="btn btn-info">show all trainee reservations</a> @stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <form action="{{ route('trainees.update', $trainee->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="form-body">
                                        <h3 class="box-title">Account details
                                            <button class="btn btn-danger text-uppercase pull-right" data-toggle="modal" data-target=".update-status" type="button">
                                                account is {{ $trainee->status }}, click to update trainee status
                                            </button>
                                        </h3>
                                        @if($trainee->remarks) <p class="text-muted">{{ $trainee->remarks }}</p> @endif
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">User Name</label>
                                                    <p class="font-bold" style="font-size: 1.5em">{{ $trainee->user->username }}</p>
                                                    <span class="help-block"> Username cannot be changed. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" class="form-control" name="email" placeholder="example@mail.com" value="{{ $trainee->user->email }}">
                                                    @if($errors->has('email')) <span class="help-block text-danger">{{ $errors->first('email') }}</span> @endif
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <h3 class="box-title m-t-30">Trainee Personal Info</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group col-md-4 p-l-0">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text" class="form-control" placeholder="Esmeraldo" name="first_name" value="{{ $trainee->first_name }}" />
                                                    @if($errors->has('first_name')) <span class="help-block text-danger">{{ $errors->first('first_name') }}</span> @endif
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="control-label">Middle Name</label>
                                                    <input type="text" class="form-control" placeholder="Barrios" name="middle_name" value="{{ $trainee->middle_name }}" />
                                                    @if($errors->has('middle_name')) <span class="help-block text-danger">{{ $errors->first('middle_name') }}</span> @endif
                                                </div>
                                                <div class="form-group col-md-4 p-r-0">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" class="form-control" placeholder="de Guzman Jr" name="last_name" value="{{ $trainee->last_name }}" />
                                                    @if($errors->has('last_name')) <span class="help-block text-danger">{{ $errors->first('last_name') }}</span> @endif
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Birth Date</label>
                                                    <input type="text" class="form-control date-mask" placeholder="YYYY-MM-DD" name="birth_date" value="{{ $trainee->birth_date }}" />
                                                    @if($errors->has('birth_date')) <span class="help-block text-danger">{{ $errors->first('birth_date') }}</span> @endif
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Gender</label>
                                                    <select name="rank" class="selectpicker form-control">
                                                        <option value="male" {{ $trainee->gender == 'male'? 'selected' : '' }}>Male</option>
                                                        <option value="female" {{ $trainee->gender == 'female'? 'selected' : '' }}>Female</option>
                                                    </select>
                                                    @if($errors->has('gender')) <span class="help-block text-danger">{{ $errors->first('gender') }}</span> @endif
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Address</label>
                                                    <textarea name="address" rows="2" class="form-control">{{ $trainee->address }}</textarea>
                                                    @if($errors->has('address')) <span class="help-block text-danger">{{ $errors->first('address') }}</span> @endif
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Rank</label>
                                                    <select name="rank" class="selectpicker form-control">
                                                        <option value="cadet" {{ $trainee->rank == 'cadet'? 'selected' : '' }}>Cadet</option>
                                                        <option value="master i" {{ $trainee->rank == 'master i'? 'selected' : '' }}>Master I</option>
                                                        <option value="engineer" {{ $trainee->rank == 'engineer'? 'selected' : '' }}>Engineer</option>
                                                        <option value="chef" {{ $trainee->rank == 'chef'? 'selected' : '' }}>Chef</option>
                                                    </select>
                                                    @if($errors->has('rank')) <span class="help-block text-danger">{{ $errors->first('rank') }}</span> @endif
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Company</label>
                                                    <input class="form-control" type="text" name="company" placeholder="Trainee did not add a company name" value="{{ $trainee->company }}" />
                                                    @if($errors->has('company')) <span class="help-block text-danger">{{ $errors->first('company') }}</span> @endif
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Mobile Number</label>
                                                    <input class="form-control mobile-number-mask" type="text" name="mobile_number" placeholder="09652865662" value="{{ $trainee->mobile_number }}" />
                                                    @if($errors->has('mobile_number')) <span class="help-block text-danger">{{ $errors->first('mobile_number') }}</span> @endif
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Telephone Number</label>
                                                    <input class="form-control" type="text" name="telephone_number" placeholder="Trainee did not add a telephone number" value="{{ $trainee->telephone_number }}" />
                                                    @if($errors->has('telephone_number')) <span class="help-block text-danger">{{ $errors->first('telephone_number') }}</span> @endif
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6 col-md-offset-6">
                                                <div class="form-group">
                                                    <label class="control-label">Remarks</label>
                                                    <textarea class="form-control" type="text" name="remarks" rows="3" placeholder="Updating trainee information needs remarks for it saved. Type the remarks here.">{{ old('remarks') }}</textarea>
                                                    @if($errors->has('remarks')) <span class="help-block text-danger">{{ $errors->first('remarks') }}</span> @endif
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <!--/row-->
                                        </div>
                                        @if($trainee->status == 'active')
                                            <div class="form-actions m-t-40 text-right">
                                                <button type="button" class="btn btn-danger" onclick="window.history.back();"><i class="fa fa-close"></i> Cancel</button>
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                            </div>
                                        @endif
                                        <h3 class="box-title">History Details
                                        </h3>
                                        @if($trainee->remarks) <p class="text-muted">{{ $trainee->remarks }}</p> @endif
                                        <hr>
                                        <div class="row">
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
                                                @if($trainee->hasHistory())
                                                    @foreach($trainee->history() as $history)
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
                                        <!--/row-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- update trainee status -->
    <div class="modal fade update-status" tabindex="-1" role="dialog" aria-labelledby="updateStatus" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="updateStatus">Change Trainee Status</h4> </div>
                <form action="{{ route('trainees.update', $trainee->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="status" class="control-label">Status</label>
                            <select name="status" class="selectpicker form-control">
                                <option value="active" {{ $trainee->status == 'active'? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $trainee->status == 'inactive'? 'selected' : '' }}>Inactive</option>
                                <option value="terminated" {{ $trainee->status == 'terminated'? 'selected' : '' }}>Terminated</option>
                                <option value="suspended" {{ $trainee->status == 'suspended'? 'selected' : ''}}>Suspended</option>
                            </select>
                            <p class="text-muted text-uppercase m-t-5">select new status.</p>
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="control-label">Remarks</label>
                            <textarea class="form-control" rows="3" name="remarks"></textarea>
                            <p class="text-muted text-uppercase m-t-5">To update this status, please provide a reason/remarks for future reference.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">save status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /update trainee status -->
@stop
@section('page-scripts')
    <script src="{{ asset('multiselect/js/jquery.multi-select.js')}}"></script>
    <!-- masked input -->
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>

    <script>
        $('.date-mask').mask('0000-00-00');
        $('.mobile-number-mask').mask('+63900-0000-000');

        $('#history').dataTable({
            'aaSorting': []
        })

        // highlight workaround start
        function removeHighlight() {
            $('#home-sidebar').removeClass('active')
            $('#reservations-sidebar').removeClass('active')
            $('#developer-sidebar').removeClass('active')
        }

        setTimeout(removeHighlight, 100)
        // highlight workaround end

        $('#roles').multiSelect({
            selectableHeader: "<div class='bg-danger text-center' style='color: white; font-weight: bold'>Inactive Roles</div>",
            selectionHeader: "<div class='bg-success text-center' style='color: white; font-weight: bold'>Active Roles</div>",
        });
    </script>
@stop