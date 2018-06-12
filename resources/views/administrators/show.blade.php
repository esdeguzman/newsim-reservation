@extends('layouts.main')
@section('page-tab-title') Courses @stop
@section('page-specific-link') <link rel="stylesheet" type="text/css" href="{{ asset('multiselect/css/multi-select.css') }}"> @stop
@section('active-page')
    <li><a href="{{ route('administrators.index') }}">Administrators</a></li>
    <li class="active">Esmeraldo de Guzman Jr</li>
@stop
@section('user-management-sidebar-menu') active @stop
@section('page-short-description') @stop
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
                                        <h3 class="box-title m-t-30">Employee Info</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Employee ID</label>
                                                    <input type="text" class="form-control" placeholder="8002568956"> <span class="help-block"> This is inline help </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Full Name</label>
                                                    <input type="email" class="form-control" placeholder="Esmeraldo Barrios de Guzman Jr"> <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Branch</label>
                                                    <select name="branch_id" class="selectpicker form-control">
                                                        <option value="1">Bacolod</option>
                                                        <option value="2">Cebu</option>
                                                        <option value="3">Davao</option>
                                                        <option value="4">Ilo-ilo</option>
                                                        <option value="5">Makati</option>
                                                    </select>
                                                    <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Status</label>
                                                    <h3><span class="label label-success">active</span><button class="pull-right btn btn-danger text-uppercase" type="button" data-toggle="modal" data-target=".update-status">update status</button></h3>
                                                    <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group col-md-6 p-l-0">
                                                    <label class="control-label">Position</label>
                                                    <select name="position_id" class="selectpicker form-control">
                                                        <option value="1">Programmer</option>
                                                        <option value="2">Chief IT Officer</option>
                                                        <option value="3">Chief Accounting Officer</option>
                                                        <option value="4">Chief Registration Officer</option>
                                                        <option value="5">Chief Training Officer</option>
                                                    </select>
                                                    <span class="help-block"> This field has error. </span>
                                                </div>
                                                <div class="form-group col-md-6  p-r-0">
                                                    <label class="control-label">Department</label>
                                                    <select name="department_id" class="selectpicker form-control">
                                                        <option value="1">I.T.</option>
                                                        <option value="2">Accounting</option>
                                                        <option value="3">Training</option>
                                                        <option value="4">Registration</option>
                                                    </select>
                                                    <span class="help-block"> This field has error. </span>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <h3 class="m-t-20">Roles</h3>
                                                <hr>
                                                <p class="pull-right col-md-6">
                                                    To assign a role to the administrator, click any of the roles listed on the <b class="bg-danger" style="color: white">&nbsp;Inactive Roles&nbsp;</b> tab. <br/><br/>
                                                    To revoke a role from this administrator, click the role you wish to revoke from the <b class="bg-success" style="color: white">&nbsp;Active Roles&nbsp;</b> tab. <br/><br/>
                                                    Do not forget to click <b class="text-uppercase text-success">save button</b> below to save your changes.
                                                </p>
                                                <select id='roles' multiple='multiple'>
                                                    <option value='elem_1' selected="selected"  style="font-weight: bold">confirm reservation</option>
                                                    <option value='elem_2'>edit reservation</option>
                                                    <option value='elem_3'>cancel reservation</option>
                                                </select>
                                            </div>
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