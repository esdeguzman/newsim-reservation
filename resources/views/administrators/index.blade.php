@extends('layouts.main')
@section('page-tab-title') Courses @stop
@section('active-page') <li class="active">Administrators</li> @stop
@section('user-management-sidebar-menu') active @stop
@section('page-short-description') All Administrators @stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Data Export</h3>
            <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
            <div class="table-responsive">
                <table id="schedules" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-uppercase">Esmeraldo Barrios de Guzman Jr</td>
                        <td class="text-uppercase">I.T.</td>
                        <td class="text-uppercase">IT Jr Programmer</td>
                        <td class="text-uppercase"><span class="label label-success text-uppercase">active</span></td>
                        <td class="text-nowrap">
                            <a href="{{ route('administrators.show', 1) }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
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
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->.
    <script>
        $('#schedules').DataTable({
            dom: 'Bfrtip'
            , buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            'aaSorting' : []
        });

        // highlight workaround start
        function removeHighlight() {
            $('#home-sidebar').removeClass('active')
            $('#reservations-sidebar').removeClass('active')
        }

        setTimeout(removeHighlight, 100)
        // highlight workaround end
    </script>
@stop