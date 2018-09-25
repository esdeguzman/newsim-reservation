@extends('layouts.trainee-main')
@section('page-tab-title') Schedules @stop
@section('active-page') <li class="active">Schedules</li> @stop
@section('schedules-sidebar-menu') active @stop
@section('page-short-description') {{ config('app.name') }} @stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box">
            <div class="table-responsive">
                <table id="schedules" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center">Branch</th>
                        <th class="text-center">Course</th>
                        <th class="text-center">Month</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">Reservations</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(optional($schedules)->count() > 0)
                        @foreach($schedules as $schedule)
                        <tr>
                            <td class="text-uppercase text-center">{{ $schedule->branch->name }}</td>
                            <td class="text-uppercase text-center">{{ $schedule->branchCourse->details->code }}</td>
                            <td class="text-uppercase text-center">{{ $schedule->monthName() }}</td>
                            <td class="text-center text-center">{{ $schedule->discountPercentage() }}</td>
                            <td class="text-center">
                                {{ optional($schedule->reservations)->count() + \App\Helper\addedWalkinApplicants($schedule->batch) }} / {{ $schedule->batch->capacity }}
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ route('trainee-schedules.show', $schedule->id) }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
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
        $('#schedules').DataTable();

        // highlight workaround start
        function removeHighlight() {
            $('#home-sidebar').removeClass('active')
            @if(isset($branch)) $('#all-schedules').removeClass('active') @endif
        }

        setTimeout(removeHighlight, 100)
        // highlight workaround end

        $('#branch-filter').on('change', function () {
            $('#form-branch-filter').submit()
        })
    </script>
@stop