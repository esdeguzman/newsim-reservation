@extends('layouts.main')
@section('page-tab-title') Schedules @stop
@section('page-specific-link')
    <!-- bootstrap-select -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
@stop
@section('active-page') <li class="active">Schedules</li> @stop
@section('schedules-sidebar-menu') active @stop
@section('page-short-description') <a href="#" class="btn btn-success"  data-toggle="modal" data-target=".add-schedule">add new schedule</a> @stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box">
            <a href="{{ route('schedules.index') }}" class="text-uppercase btn btn-danger pull-right">see all branch schedules</a>
            <h3 class="box-title m-b-0">Data Export</h3>
            <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
            <div class="table-responsive">
                <table id="schedules" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Branch</th>
                        <th>Course</th>
                        <th>Month</th>
                        <th>Discount</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Reservations</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-uppercase">makati</td>
                        <td class="text-uppercase">bosiet</td>
                        <td class="text-uppercase">january</td>
                        <td class="text-center">50%</td>
                        <td class="text-center">
                            <span class="label label-success">new</span>
                        </td>
                        <td class="text-center">
                            <span class="label label-success">25</span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('schedules.show', 1) . '?branch="makati"' }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-uppercase">makati</td>
                        <td class="text-uppercase">bosiet in-house</td>
                        <td class="text-uppercase">january</td>
                        <td class="text-center">30%</td>
                        <td class="text-center">
                            <span class="label label-info">updated</span>
                        </td>
                        <td class="text-center">
                            <span class="label label-warning">35</span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('schedules.show', 1) . '?branch="makati"' }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-uppercase">makati</td>
                        <td class="text-uppercase">bosiet refresher</td>
                        <td class="text-uppercase">january</td>
                        <td class="text-center">60%</td>
                        <td class="text-center">
                            <span class="label label-danger">repriced</span>
                        </td>
                        <td class="text-center">
                            <span class="label label-danger">45</span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('schedules.show', 1) . '?branch="makati"' }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- confirm reservation -->
    <div class="modal fade add-schedule" tabindex="-1" role="dialog" aria-labelledby="addSchedule" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="addSchedule">add schedule</h4> </div>
                <form action="#">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="course" class="control-label">Course</label>
                            <select name="course" id="course" class="selectpicker form-control" data-live-search="true" >
                                <option value="" class="hidden">Click to select course</option>
                            </select>
                            <p class="text-muted text-uppercase m-t-5">course description</p>
                            <p>Update <a href="#"><b class="text-uppercase">course</b></a> details! <br/>
                                <span class="text-danger"><strong class="text-uppercase">warning!</strong> Clicking update link will discard this transaction.</span>
                            </p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Original Price</label>
                            <div class="form-control-static">
                                <h1>P 3,000.00</h1>
                                <p>Update <a href="#"><b class="text-uppercase">original price</b></a>! <br/>
                                    <span class="text-danger"><strong class="text-uppercase">warning!</strong> Clicking update link will discard this transaction.</span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="discount" class="control-label">Discount</label>
                            <input class="form-control discount" type="text" id="discount" name="discount" />
                            <p class="text-muted text-uppercase m-t-5">this will <b class="text-danger">only</b> be applied to this schedule</p>
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
                            <p class="text-muted text-uppercase m-t-5">select which month the class will be conducted.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">add schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /confirm reservation -->
@stop
@section('page-scripts')
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->.
    <!-- bootstrap-select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <script>
        $('#schedules').DataTable({
            dom: 'Bfrtip'
            , buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        // highlight workaround start
        function removeHighlight() {
            $('#home-sidebar').removeClass('active')
            $('#reservations-sidebar').removeClass('active')
        }

        setTimeout(removeHighlight, 100)
        // highlight workaround end

        $('.discount').mask('000.00%', {reverse: true});
    </script>
@stop