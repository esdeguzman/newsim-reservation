@extends('layouts.main')
@section('active-page')
    @if($branch) <li><a href="{{ url('reservations.index') }}?branch={{ $branch }}" class="active">Reservations</a></li> <li class="text-capitalize text-muted">{{ $branch }}</li>
    @else <li class="active">Reservations</li>
    @endif
@stop
@section('reservations-sidebar-menu') active @stop
@section('page-short-description') {{ config('app.name') }} @stop
@section('page-content')
<div class="col-md-12">
    <div class="white-box">
        <h3 class="box-title m-b-0">Data Export</h3>
        <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
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
                <tbody>
                @if(isset($reservations))
                <tr>
                    <td>ND-9093-22312</td>
                    <td>BOSIET</td>
                    <td>DECEMBER</td>
                    <td>MAY 31, 2018</td>
                    <td>
                        <span class="label label-success">new</span>
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('reservations.show', 1) }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                    </td>
                </tr>
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
    $('#example23').DataTable({
        dom: 'Bfrtip'
        , buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // highlight workaround start
    function removeHighlight() {
        $('#home-sidebar').removeClass('active')
        @if(isset($branch)) $('#all-reservations').removeClass('active') @endif
    }

    setTimeout(removeHighlight, 100)
    // highlight workaround end
</script>
@stop