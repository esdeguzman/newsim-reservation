@extends('layouts.main')
@section('page-tab-title') Courses @stop
@section('active-page') <li class="active">Courses</li> @stop
@section('courses-sidebar-menu') active @stop
@section('page-short-description') @if(\App\Helper\user()->isDev() or \App\Helper\user()->isSystemAdmin()) <a href="#" class="btn btn-success" data-toggle="modal" data-target=".add-course">add new course</a> @endif @stop
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
                        <th class="text-center">Category</th>
                        <th class="text-center">Accreditation Body</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td class="text-uppercase">{{ $course->code }}</td>
                            <td class="text-uppercase">{{ $course->description }}</td>
                            <td class="text-uppercase text-center">{{ $course->category }}</td>
                            <td class="text-uppercase text-center">{{ $course->accreditation_body }}</td>
                            <td class="text-uppercase text-center">{{ $course->duration  }} {{ $course->duration > 1? 'days' : 'day' }}</td>
                            <td class="text-uppercase text-center">
                            <span class="label
                            @if($course->status == 'active') label-success
                            @elseif($course->status == 'restored') label-info
                            @elseif($course->status == 'deleted') label-danger
                            @endif
                            ">{{ $course->status }}</span></td>
                            <td class="text-center">
                                <a href="{{ route('courses.show', $course->id) }}" class="text-uppercase"> <i class="fa fa-eye m-r-10"></i>view</a>
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
                            <label for="code" class="control-label">Code *</label>
                            <input class="form-control code" type="text" id="code" name="code" value="{{ old('code') }}" />
                            <p class="text-muted m-t-5">i.e. <b>bosiet</b></p>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Description *</label>
                            <input class="form-control description" type="text" id="description" name="description" value="{{ old('description') }}" />
                            <p class="text-muted m-t-5">i.e. <b>basic offshore safety induction and emergency training</b></p>
                        </div>
                        <div class="form-group">
                            <label for="category" class="control-label">Category *</label>
                            <select class="form-control text-uppercase" name="category" id="category">
                                <option class="text-uppercase" value="common">common</option>
                                <option class="text-uppercase" value="deck">deck</option>
                                <option class="text-uppercase" value="engine">engine</option>
                                <option class="text-uppercase" value="off-shore">off-shore</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="accreditation_body" class="control-label">Accreditation Body *</label>
                            <select class="form-control text-uppercase" name="accreditation_body" id="accreditation_body">
                                <option class="text-uppercase" value="marina">marina</option>
                                <option class="text-uppercase" value="opito">opito</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duration" class="control-label">Duration *</label>
                            <input class="form-control duration" type="number" id="duration" name="duration" value="{{ old('duration') }}" placeholder="Please enter duration in days" />
                            <p class="text-muted m-t-5">i.e. <b>6</b></p>
                        </div>
                        <div class="form-group">
                            <label for="aims" class="control-label">Aims <b class="text-info">(optional)</b></label>
                            <textarea class="form-control" name="aims" id="aims" rows="3">{{ old('aims') }}</textarea>
                            <p class="text-muted m-t-5">i.e. <b>The aim of the Escape Chute Refresher Training programme is to ensure delegates maintain their knowledge and skills in the use of escape chutes as a means of tertiary escape from offshore installations and vessels.</b></p>
                        </div>
                        <div class="form-group">
                            <label for="objectives_header" class="control-label">Objectives Header <b class="text-info">(optional)</b></label>
                            <textarea class="form-control" name="objectives_header" id="objectives_header" rows="3">{{ old('objectives_header') }}</textarea>
                            <p class="text-muted m-t-5">i.e. <b>To update and maintain knowledge and skills in the following:</b></p>
                        </div>
                        <div class="form-group">
                            <label for="objectives" class="control-label">Objectives <b class="text-info">(optional)</b></label>
                            <textarea class="form-control" name="objectives" id="objectives" rows="3">{{ old('objectives') }}</textarea>
                            <p class="text-muted m-t-5">i.e. <b>To make delegates aware of the various types of escape chutes used on offshore installations and vessels To provide theoretical and practical training in the safe techniques for escaping through an escape chute To ensure delegates understand what they are required to do when exiting the escape chute </b></p>
                        </div>
                        <div class="form-group">
                            <label for="prerequisites" class="control-label">Prerequisites <b class="text-info">(optional)</b></label>
                            <textarea class="form-control" name="prerequisites" id="prerequisites" rows="3">{{ old('prerequisites') }}</textarea>
                            <p class="text-muted m-t-5">i.e.<br><b>Medical Certificate<br>Valid OPITO approved Escape Chute Training or Refresher Training certificate.</b></p>
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

        $('#code, #description').on('keyup', function () {
            $(this).val($(this).val().toLowerCase())
        });
    </script>
@stop