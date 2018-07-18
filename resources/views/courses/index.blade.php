@extends('layouts.main')
@section('page-tab-title') Courses @stop
@section('active-page') <li class="active">Courses</li> @stop
@section('courses-sidebar-menu') active @stop
@section('page-short-description') <a href="#" class="btn btn-success" data-toggle="modal" data-target=".add-course">add new course</a> @stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Data Export</h3>
            <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
            <div class="table-responsive">
                <table id="schedules" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td class="text-uppercase">{{ $course->code }}</td>
                            <td class="text-uppercase">{{ $course->description }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('courses.show', $course->id) }}" class="text-uppercase text-success"> <i class="fa fa-eye text-success m-r-10"></i>view</a>&nbsp;&nbsp;&nbsp;
                                <a href="#" class="text-uppercase edit_course text-warning" data-toggle="modal" data-target=".edit-course"
                                   data-course-id="{{ $course->id }}" data-course-code="{{ $course->code }}"
                                   data-course-description="{{ $course->description }}"> <i class="fa fa-edit text-warning m-r-10"></i>edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- add course -->
    <div class="modal fade add-course" tabindex="-1" role="dialog" aria-labelledby="addCourse" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="addCourse">add course</h4> </div>
                <form action="{{ route('courses.store') }}" method="post">
                    @csrf
                    <input type="number" name="added_by" value="{{ \App\Helper\admin()->id }}" hidden />
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code" class="control-label">Code</label>
                            <input class="form-control code" type="text" id="code" name="code" value="{{ old('code') }}" />
                            <p class="text-muted m-t-5">i.e. <b>bosiet</b></p>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Description</label>
                            <input class="form-control description" type="text" id="description" name="description" value="{{ old('description') }}" />
                            <p class="text-muted m-t-5">i.e. <b>basic offshore safety induction and emergency training</b></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">add course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /add course -->

    <!-- edit course -->
    <div class="modal fade edit-course" tabindex="-1" role="dialog" aria-labelledby="editCourse" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="editCourse">edit course</h4> </div>
                <form action="#" method="post" id="edit_course_form">
                    {{ csrf_field() }} {{ method_field('put') }}
                    <input type="text" class="hidden" name="redirect_path" value="{{ route('courses.index') }}" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code" class="control-label">Code *</label>
                            <input class="form-control code" type="text" id="edit_code" name="code" />
                            <p class="text-muted m-t-5">i.e. <b>bosiet</b></p>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Description *</label>
                            <input class="form-control description" type="text" id="edit_description" name="description" />
                            <p class="text-muted m-t-5">i.e. <b>basic offshore safety induction and emergency training</b></p>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks *</label>
                            <textarea type="text" class="form-control form-material" name="remarks" id="remarks" cols="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">update course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /edit course -->
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

        $('#code').on('keyup', function () {
            $(this).val($(this).val().toLowerCase())
        });

        $('#description').on('keyup', function () {
            $(this).val($(this).val().toLowerCase())
        });

        $('.edit_course').on('click', function () {
            let courseUpdateUrl = '{{ url("admin/courses/") }}' + '/' + $(this).data('course-id')
            let code = $(this).data('course-code')
            let description = $(this).data('course-description')

            $('#edit_code').val(code)
            $('#edit_description').val(description)
            $('#edit_course_form').attr('action', courseUpdateUrl)
        })
    </script>
@stop