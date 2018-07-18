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
                        <th class="text-left">Reservation Code</th>
                        <th class="text-center">Course</th>
                        <th class="text-center">Month</th>
                        <th class="text-center">Date Reserved</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($reservations))
                        @foreach($reservations as $reservation)
                        <tr>
                            <td class="text-left">{{ $reservation->code }}</td>
                            <td class="text-center">{{ strtoupper($reservation->schedule->branchCourse->details->code) }}</td>
                            <td class="text-center">{{ $reservation->schedule->monthName() }}</td>
                            <td class="text-center">{{ \App\Helper\toReadableDate($reservation->created_at) }}</td>
                            <td class="text-center">
                                <span class="label text-uppercase
                                @if($reservation->status == 'new') label-success
                                @elseif($reservation->status == 'cancelled' || $reservation->status == 'underpaid' || $reservation->status == 'expired') label-danger
                                @elseif($reservation->status == 'paid' || $reservation->status == 'registered') label-info
                                @elseif($reservation->status == 'pending' || $reservation->status == 'overpaid') label-warning
                                @endif
                                ">{{ $reservation->status }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('trainee-reservations.show', $reservation->id) }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
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
    <script>
        $('#example23').dataTable({
            'aaSorting': []
        });

        // highlight workaround start
        function removeHighlight() {
            $('#home-sidebar').removeClass('active')
        }

        setTimeout(removeHighlight, 100)
        // highlight workaround end
    </script>
@stop