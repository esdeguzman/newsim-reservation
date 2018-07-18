@extends('layouts.main')
@section('active-page')
    @if($branch) <li><a href="{{ url('admin/reservations/') }}?branch={{ $branch->name }}" class="active">Reservations</a></li> <li class="text-capitalize text-muted">{{ $branch->name }}</li>
    @else <li class="active">Reservations</li> @endif
    @if($trainee) <li>{{ $trainee->fullName() }}</li> @endif
@stop
@section('reservations-sidebar-menu') active @stop
@section('page-short-description') {{ config('app.name') }} @stop
@section('page-content')
<div class="col-md-12">
    <div class="white-box">
        @if(! $trainee) <a href="{{ route('reservations.index') }}?status=cancelled" class="btn btn-danger pull-right text-uppercase">show cancelled</a> @endif
        <h3 class="box-title m-b-0">Data Export</h3>
        <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
        <div class="table-responsive">
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Reservation Code</th>
                    <th class="text-center">Course</th>
                    <th class="text-center">Month</th>
                    <th class="text-center">Date Reserved</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(optional($reservations)->count() > 0)
                    @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->code }}</td>
                        <td class="text-uppercase text-center">{{ $reservation->schedule->branchCourse->details->code }}</td>
                        <td class="text-center">{{ $reservation->schedule->monthName() }}</td>
                        <td class="text-center">{{ \App\Helper\toReadableDate($reservation->created_at) }}</td>
                        <td class="text-center">
                            <span class="label
                            @if($reservation->status == 'new') label-success
                            @elseif($reservation->status == 'cancelled' || $reservation->status == 'pending' || $reservation->status == 'overpaid') label-warning
                            @elseif($reservation->status == 'paid' || $reservation->status == 'registered') label-info
                            @elseif($reservation->status == 'underpaid') label-danger
                            @endif
                            text-uppercase">{{ $reservation->status }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('reservations.show', $reservation->id) }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
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
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>e
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<!-- end - This is for export functionality only -->.
<script>
    $('#example23').DataTable({
        dom: 'Bfrtip'
        , buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        'aaSorting' : []
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