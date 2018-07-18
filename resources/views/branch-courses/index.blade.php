@extends('layouts.main')
@section('page-tab-title') Branch Courses @stop
@section('page-specific-link')
    <!-- bootstrap-select -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
@stop
@section('active-page')
    @if(isset($branch->id))
        <li><a href="{{ route('branch-courses.index') . '?filter=all_branches' }}" class="active">Branch Courses</a></li>
        <li class="text-capitalize text-muted">{{ $branch->name }}</li>
        @else <li class="active">Branch Courses</li>
    @endif
@stop
@section('branch-courses-sidebar-menu') active @stop
@section('page-short-description') @if(isset($branch->id)) <a href="#" class="btn btn-success" data-toggle="modal" data-target=".add-branch-course">add new branch course</a> @endif @stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Data Export</h3>
            <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
            <div class="table-responsive">
                <table id="schedules" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Branch</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($branchCourses->count() > 0)
                        @foreach($branchCourses as $branchCourse)
                            <tr>
                                <td class="text-uppercase">{{ $branchCourse->branch->name }}</td>
                                <td class="text-uppercase">{{ $branchCourse->details->code }}</td>
                                <td class="text-uppercase">{{ $branchCourse->details->description }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('branch-courses.show', $branchCourse->id) . '/?branch=' . $branchCourse->branch->name }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- add course -->
    <div class="modal fade add-branch-course" tabindex="-1" role="dialog" aria-labelledby="addBranchCourse" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="addBranchCourse">add course</h4> </div>
                <form action="{{ route('branch-courses.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code" class="control-label">Course</label>
                            <select name="course_id" class="selectpicker form-control" data-live-search="true">
                                <option value="" class="hidden">Select course</option>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}" class="text-uppercase">{{ $course->code }} - {{ str_limit($course->description, 55) }}</option>
                                @endforeach
                            </select>
                            @if(isset($branch->id)) <input type="text" name="branch_id" value="{{ $branch->id }}" class="hidden" /> @endif
                            <p class="text-muted m-t-5"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">add branch course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /add course -->
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
    <!-- end - This is for export functionality only -->
    <!-- bootstrap-select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
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
            $('#courses-sidebar').removeClass('active')
            $('#reservations-sidebar').removeClass('active')
        }

        setTimeout(removeHighlight, 100)
        // highlight workaround end
    </script>
@stop