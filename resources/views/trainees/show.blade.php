@extends('layouts.main')
@section('page-tab-title') Courses @stop
@section('page-specific-link') <link rel="stylesheet" type="text/css" href="{{ asset('multiselect/css/multi-select.css') }}"> @stop
@section('active-page')
    <li><a href="{{ route('trainees.index') }}">Trainees</a></li>
    <li class="active">Esmeraldo de Guzman Jr</li>
@stop
@section('administrators-sidebar-menu') active @stop
@section('page-short-description') <a href="{{ route('reservations.index') . '?show_all="true"&trainee_id=1' }}" class="btn btn-info">show all trainee reservations</a> @stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <form action="#">
                                    <div class="form-body">
                                        <h3 class="box-title">Account details</h3>
                                        <p class="text-muted">If remarks is available, show it here</p>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">User Name</label>
                                                    <p class="font-bold" style="font-size: 1.5em">esdeguzman</p>
                                                    <span class="help-block"> Username cannot be changed. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" class="form-control" placeholder="example@mail.com"> <span class="help-block"> This field has error. </span>
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
                                                    <input type="text" class="form-control" placeholder="Esmeraldo" name="first_name" /> <span class="help-block"> This field has error. </span>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="control-label">Middle Name</label>
                                                    <input type="text" class="form-control" placeholder="Barrios" name="middle_name" /> <span class="help-block"> This field has error. </span>
                                                </div>
                                                <div class="form-group col-md-4 p-r-0">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" class="form-control" placeholder="de Guzman Jr" name="last_name" /> <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Birth Date</label>
                                                    <input type="text" class="form-control" placeholder="06/24/1990" name="birth_date" />
                                                    <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Gender</label>
                                                    <select name="rank" class="selectpicker form-control">
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                    <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Address</label>
                                                    <textarea name="address" rows="2" class="form-control">711-2880 Nulla St. Mankato Mississippi 6522</textarea>
                                                    <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Rank</label>
                                                    <select name="rank" class="selectpicker form-control">
                                                        <option value="cadet">Cadet</option>
                                                        <option value="master i">Master I</option>
                                                        <option value="engineer">Engineer</option>
                                                        <option value="chef">Chef</option>
                                                    </select>
                                                    <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Company</label>
                                                    <input class="form-control" type="text" name="company" placeholder="Trainee didn't add a company name" />
                                                    <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Mobile Number</label>
                                                    <input class="form-control" type="text" name="mobile_number" placeholder="09652865662" />
                                                    <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Telephone Number</label>
                                                    <input class="form-control" type="text" name="telephone_number" placeholder="Trainee didn't add a telephone number" />
                                                    <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <!--/row-->
                                        </div>
                                    </div>
                                    <div class="form-actions m-t-40 text-right">
                                        <button type="button" class="btn btn-danger" onclick="window.history.back();"><i class="fa fa-close"></i> Cancel</button>
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- confirm reservation -->
    <div class="modal fade update-status" tabindex="-1" role="dialog" aria-labelledby="updateStatus" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="updateStatus">Change Admin Status</h4> </div>
                <form action="#">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="month" class="control-label">Status</label>
                            <select name="department_id" class="selectpicker form-control">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                                <option value="3">Terminated</option>
                                <option value="4">Suspended</option>
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
    <!-- /confirm reservation -->
@stop
@section('page-scripts')
    <script src="{{ asset('multiselect/js/jquery.multi-select.js')}}"></script>
    <script>
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