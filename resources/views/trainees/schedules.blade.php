@extends('layouts.trainee-main')
@section('page-tab-title') Schedules @stop
@section('active-page') <li class="active">Schedules</li> @stop
@section('schedules-sidebar-menu') active @stop
@section('page-short-description')
    <form action="{{ route('trainee.schedules') }}" method="get" id="form-branch-filter">
        <select name="branch" class="col-md-3" id="branch-filter">
            <option value="all">All Branches</option>
            <option value="bacolod">Bacolod</option>
            <option value="cebu">Cebu</option>
            <option value="davao">Davao</option>
            <option value="iloilo">Ilo-ilo</option>
            <option value="makati">Makita</option>
        </select>
    </form>
@stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box">
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
                            <a href="{{ route('trainee.schedule-show', 1) }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-uppercase">cebu</td>
                        <td class="text-uppercase">bosiet in-house</td>
                        <td class="text-uppercase">january</td>
                        <td class="text-center">50%</td>
                        <td class="text-center">
                            <span class="label label-info">updated</span>
                        </td>
                        <td class="text-center">
                            <span class="label label-warning">35</span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('trainee.schedule-show', 1) }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-uppercase">bacolod</td>
                        <td class="text-uppercase">bosiet refresher</td>
                        <td class="text-uppercase">january</td>
                        <td class="text-center">50%</td>
                        <td class="text-center">
                            <span class="label label-danger">repriced</span>
                        </td>
                        <td class="text-center">
                            <span class="label label-danger">45</span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('trainee.schedule-show', 1) }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
@section('page-scripts')
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $('#schedules').DataTable();

        // highlight workaround start
        function removeHighlight() {
            $('#home-sidebar').removeClass('active')
            $('#reservations-sidebar').removeClass('active')
        }

        setTimeout(removeHighlight, 100)
        // highlight workaround end

        $('#branch-filter').on('change', function () {
            $('#form-branch-filter').submit()
        })
    </script>
@stop