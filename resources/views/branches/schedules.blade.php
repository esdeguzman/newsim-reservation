@extends('layouts.main')
@section('page-tab-title') Schedules @stop
@section('page-specific-link')
    <!-- bootstrap-select -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
@stop
@section('active-page') <li class="active">Schedules</li> @stop
@section('schedules-sidebar-menu') active @stop
@section('page-short-description') @if(\App\Helper\adminCan('training officer')) <a href="#" class="btn btn-success" data-toggle="modal" data-target=".add-schedule">add new schedule</a> @endif @stop
@section('page-content')
    <div class="col-md-12">
        <div class="white-box">
            <a href="{{ route('schedules.index') }}" class="text-uppercase btn btn-danger pull-right">see all branch schedules</a>
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
                                    @elseif(str_contains($schedule->status, 'updated')) label-warning
                                    @endif
                                    ">{{ $schedule->status }}</span>
                                </td>
                                <td class="text-center">
                                    {{ $schedule->reservations? $schedule->reservations->count() : 0 }}
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('schedules.show', $schedule->id) . '?branch=makati' }}" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-eye text-info m-r-10"></i>VIEW</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- add schedule -->
    <div class="modal fade add-schedule" tabindex="-1" role="dialog" aria-labelledby="addSchedule" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="addSchedule">add schedule</h4> </div>
                <form action="{{ route('schedules.store') }}" method="post">
                    @csrf
                    <input type="number" name="branch_id" value="{{ optional(optional($branchCourses->first())->branch)->id }}" hidden>
                    <input type="number" name="added_by" value="{{ auth()->user()->id }}" hidden>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="branch_course_id" class="control-label">Course</label>
                            <select name="branch_course_id" id="branch_course_id" class="selectpicker form-control" data-live-search="true" >
                                <option value="" class="hidden">Click to select course</option>
                                @foreach($branchCourses as $branchCourse)
                                <option value="{{ $branchCourse->id }}" data-course-id="{{ $branchCourse->details->id }}" data-branch="{{ $branchCourse->branch->name }}" data-description="{{ $branchCourse->details->description }}" data-original-price="{{ number_format(optional($branchCourse->originalPrice)->value, 2) }}" {{ old('branch_course_id') == $branchCourse->id? 'selected' : '' }}>{{ strtoupper($branchCourse->details->code) }}</option>
                                @endforeach
                            </select>
                            <p class="text-muted text-uppercase m-t-5" id="course_description">course description</p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Original Price</label>
                            <div class="form-control-static">
                                <h1 id="original_price"></h1>
                                <p>Update <a href="#" id="update_original_price_link"><b class="text-uppercase">original price</b></a>! <br/>
                                    <span class="text-danger"><strong class="text-uppercase">warning!</strong> Clicking update link will discard this transaction.</span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="discount" class="control-label">Discount</label>
                            <input class="form-control discount" type="text" id="discount" name="discount" value="{{ old('discount') }}" />
                            <p class="text-muted text-uppercase m-t-5">this will <b class="text-danger">only</b> be applied to this schedule</p>
                        </div>
                        <div class="form-group">
                            <label for="month" class="control-label">Training Month</label>
                            <select name="month" id="month" class="selectpicker form-control">
                                <option value="" class="hidden">Click to select month</option>
                                <option value="1" {{ old('month') == 1? 'selected' : '' }}>January</option>
                                <option value="2" {{ old('month') == 2? 'selected' : '' }}>February</option>
                                <option value="3" {{ old('month') == 3? 'selected' : '' }}>March</option>
                                <option value="4" {{ old('month') == 4? 'selected' : '' }}>April</option>
                                <option value="5" {{ old('month') == 5? 'selected' : '' }}>May</option>
                                <option value="6" {{ old('month') == 6? 'selected' : '' }}>June</option>
                                <option value="7" {{ old('month') == 7? 'selected' : '' }}>July</option>
                                <option value="8" {{ old('month') == 8? 'selected' : '' }}>August</option>
                                <option value="9" {{ old('month') == 9? 'selected' : '' }}>September</option>
                                <option value="10" {{ old('month') == 10? 'selected' : '' }}>October</option>
                                <option value="11" {{ old('month') == 11? 'selected' : '' }}>November</option>
                                <option value="12" {{ old('month') == 12? 'selected' : '' }}>December</option>
                            </select>
                            <p class="text-muted text-uppercase m-t-5">select which month the class will be conducted.</p>
                        </div>
                        <div class="form-group">
                            <label for="year" class="control-label">Training Year</label>
                            <input class="form-control" type="number" name="year" value="{{ \Carbon\Carbon::now()->year }}"/>
                            <p class="text-muted text-uppercase m-t-5"></p>
                        </div>
                        <input type="text" name="course_id" id="course_id" hidden />
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">add schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /add schedule -->
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
            ]
        });

        // highlight workaround start
        function removeHighlight() {
            $('#home-sidebar').removeClass('active')
            $('#reservations-sidebar').removeClass('active')
        }

        setTimeout(removeHighlight, 100)
        // highlight workaround end

        $('.discount').mask('000.00%', {reverse: true})

        let branchCourseId = $('#branch_course_id')

        branchCourseId.on('changed.bs.select', function (e) {
            let branchCourseId = $(this).val()
            let courseId = $(this).find(':selected').data('course-id')
            let branch = $(this).find(':selected').data('branch')
            let description = $(this).find(':selected').data('description')
            let value = $(this).find(':selected').data('original-price')
            let originalPrice = 'P ' + value? value : ''

            $('#course_description').text(description)
            $('#original_price').text(originalPrice)
            $('#course_id').val(courseId)
            $('#update_original_price_link').attr('href', '{{ url('admin/branch-courses') }}' + '/' + branchCourseId + '?branch=' + branch)
        })

        function showPrice() {
            branchCourseId.change()
        }

        setTimeout(showPrice, 100)
    </script>
@stop