@extends('layouts.main')
@section('page-tab-title') Schedules @stop
@section('active-page') <li class="active">Schedules</li> @stop
@section('schedules-sidebar-menu') active @stop
@section('page-short-description') All Plotted Schedules @stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box">
            <a href="{{ route('schedules.index') . '?branch=' . auth()->user()->administrator->branch->name }}" class="text-uppercase btn btn-danger pull-right">go to my branch</a>
            <h3 class="box-title m-b-0">Data Export</h3>
            <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
            <div class="table-responsive">
                <table id="schedules" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Branch</th>
                        <th>Course</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Discount</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Reservations</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($schedules->count() > 0)
                        @foreach($schedules as $schedule)
                            <tr>
                                <td class="text-uppercase">{{ $schedule->branchCourse->branch->name }}</td>
                                <td class="text-uppercase">{{ $schedule->branchCourse->details->code }}</td>
                                <td class="text-uppercase">{{ $schedule->monthName() }}</td>
                                <td class="text-uppercase">{{ $schedule->year }}</td>
                                <td class="text-center">{{ $schedule->discountPercentage() }}</td>
                                <td class="text-center">
                                    <span class="label
                                    @if(str_contains($schedule->status, 'new')) label-success
                                    @elseif(str_contains($schedule->status, 'updated'))
                                    @endif label-warning">{{ $schedule->status }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="label label-success">{{ optional($schedule->reservations)->count() }}</span>
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('schedules.show', $schedule->id) }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
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
            ]
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