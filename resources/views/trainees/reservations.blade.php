@extends('layouts.trainee-main')
@section('active-page')
    <li class="active">Reservations</li>
@stop
@section('reservations-sidebar-menu') active @stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box">
            <div class="table-responsive">
                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Reservation Code</th>
                        <th>Course</th>
                        <th>Month</th>
                        <th>Date Reserved</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Reservation Code</th>
                        <th>Course</th>
                        <th>Month</th>
                        <th>Date Reserved</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr>
                        <td>ND-9093-22312</td>
                        <td>BOSIET</td>
                        <td>DECEMBER</td>
                        <td>MAY 31, 2018</td>
                        <td>
                            <span class="label label-success">new</span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('trainee.reservation-show', 1) . '?show-all="true"' }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                        </td>
                    </tr>
                    <tr>
                        <td>ND-9093-22312</td>
                        <td>BOSIET</td>
                        <td>DECEMBER</td>
                        <td>MAY 31, 2018</td>
                        <td>
                            <span class="label label-warning">confirmed</span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('trainee.reservation-show', 1) . '?show-all="true"' }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                        </td>
                    </tr>
                    <tr>
                        <td>ND-9093-22312</td>
                        <td>BOSIET</td>
                        <td>DECEMBER</td>
                        <td>MAY 31, 2018</td>
                        <td>
                            <span class="label label-info">registered</span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('trainee.reservation-show', 1) . '?show-all="true"' }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                        </td>
                    </tr>
                    <tr>
                        <td>ND-9093-22312</td>
                        <td>BOSIET</td>
                        <td>DECEMBER</td>
                        <td>MAY 31, 2018</td>
                        <td>
                            <span class="label label-danger">expired</span>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('reservations.show', 1) . '?show-all="true"' }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
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
        $('#example23').DataTable();

        // highlight workaround start
        function removeHighlight() {
            $('#home-sidebar').removeClass('active')
        }

        setTimeout(removeHighlight, 100)
        // highlight workaround end
    </script>
@stop