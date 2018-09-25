@extends('layouts.main')
@section('page-tab-title') Courses @stop
@section('page-specific-link') <link href="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" /> @stop
@section('active-page')
    <li><a href="{{ route('courses.index') }}"><b class="text-info">Courses</b></a></li>
    <li class="active"><span class="text-muted text-uppercase">{{ $course->code }}</span></li>
@stop
@section('page-short-description') @stop
@section('page-content')
    <div class="col-md-12 block3">
        <div class="white-box printableArea">
            @if($course->status == 'active' || $course->status == 'restored' and \App\Helper\user()->isDev() || \App\Helper\user()->isSystemAdmin()) <button class="pull-right text-uppercase btn btn-info"  data-toggle="modal" data-target=".update-course" id="btn_edit_course">update course details</button>
            @elseif($course->status == 'deleted') <button class="pull-right text-uppercase btn btn-warning"  data-toggle="modal" data-target=".restore-course" id="btn_restore_course">restore course</button>
            @endif
            <h3 class="text-uppercase">{{ $course->code }}
                <span class="tooltip-item2"><small>{{ $course->description }}</small></span>
                <sup class="label
                @if($course->status == 'active') label-success
                @elseif($course->status == 'restored') label-info
                @elseif($course->status == 'deleted') label-danger
                @endif
                ">{{ $course->status }}</sup>
            </h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">
                        <address>
                            {{--<h3> &nbsp;<b class="text-uppercase">Esmeraldo <sup class="text-info text-uppercase">cadet</sup></b></h3>--}}
                            {{--<p class="text-muted m-l-5"><b class="text-danger text-uppercase">newsim</b> <br/>--}}
                            Category:
                            @if($course->category) <b>{{ $course->category }}</b><br><br>
                            @else <b class="text-danger">Has not been set</b><br>
                            @endif
                            Duration:
                            @if($course->duration) <b>{{ $course->duration }} {{ $course->duration > 1? 'days' : 'day' }}</b><br><br>
                            @else <b class="text-danger">Has not been set</b><br>
                            @endif
                            Accredited by:
                            @if($course->accreditation_body) <b class="text-uppercase">{{ $course->accreditation_body }}</b><br><br>
                            @else <b class="text-danger">Has not been set</b><br>
                            @endif
                            Aims:
                            @if($course->aims) <br><b>{{ $course->aims }}</b><br><br>
                            @else <b class="text-danger">Has not been set</b><br>
                            @endif
                            Objectives:
                            @if($course->objectives_header) <br><b>{{ $course->objectives_header }}</b>
                            @else <b class="text-danger">Has not been set</b><br>
                            @endif
                            @if($course->objectives) <br><br><div class="m-l-20"><b>{!! str_replace('\n\n', '<br>', $course->objectives) !!}</b></div><br>
                            @endif
                            Target Audience:
                            @if($course->target_audience) <br><b>{{ $course->target_audience }}</b><br><br>
                            @else <b class="text-danger">Has not been set</b><br>
                            @endif
                            Prerequisites:
                            @if($course->prerequisites) <br><br><div class="m-l-20"><b>{!! str_replace('\n\n', '<br>', $course->prerequisites) !!}</b></div><br>
                            @else <b class="text-danger">Has not been set</b><br>
                            @endif
                            Validity:
                            @if($course->validity) <b>{{ $course->validity }} {{ $course->validity > 1? 'years' : 'year' }}</b><br><br>
                            @else <b class="text-danger">Has not been set</b><br>
                            @endif
                        </address> </div>
                </div>
                <div class="col-md-12 m-t-20">
                    <div class="table-responsive" style="clear: both;">
                        <h3 class="text-uppercase"><code>timeline</code></h3>
                        <p class="text-muted">This shows important events happened to this course like <code class="text-uppercase">description</code> changes and more!</p>
                        <table class="table table-hover table-striped" id="history_table">
                            <thead>
                            <tr>
                                <th>Log</th>
                                <th>Remarks</th>
                                <th>Responsible</th>
                                <th>Date Amended</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($course->hasHistory())
                                @foreach($course->history() as $history)
                                <tr>
                                    <td class="text-uppercase">{{ $history->log }}</td>
                                    <td class="text-uppercase">{{ $history->remarks }}</td>
                                    <td class="text-uppercase">{{ $history->updatedBy->full_name }}</td>
                                    <td class="text-uppercase">{{ Carbon\Carbon::parse($history->created_at)->toFormattedDateString() }}</td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(is_null($course->deleted_at) and \App\Helper\user()->isDev() || \App\Helper\user()->isSystemAdmin())
                <div class="col-lg-5 col-sm-6 col-xs-12 pull-right m-t-40">
                    <div class="panel panel-danger">
                        <div class="panel-heading"> Danger Zone
                            <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-plus"></i></a> </div>
                        </div>
                        <div class="panel-wrapper collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <p>This will <b class="text-danger text-uppercase">permanently delete this course and all the history above</b>. <br/><br/>
                                    This panel is <b class="text-info text-uppercase">purposely closed by default</b>, if you are reading this,
                                    and <b class="text-danger text-uppercase">still continue to delete this course</b>; a log will be saved tagging you
                                    as the sole administrator that is <b class="text-info text-uppercase">responsible for this deletion</b>.
                                </p>
                            </div>
                            <button class="btn btn-block btn-danger text-uppercase"  data-toggle="modal" data-target=".delete-course">i understand, proceed course deletion</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- modals -->

    <!-- delete course -->
    <div class="modal fade delete-course" tabindex="-1" role="dialog" aria-labelledby="deleteCourseLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="deleteCourseLabel">confirm action</h4> </div>
                <form action="{{ route('courses.destroy', $course->id) }}" method="post">
                    {{ csrf_field() }} {{ method_field('delete') }}
                    <div class="modal-body">
                        Deleting a course requires <b class="text-uppercase text-info">remarks</b> for future reference. <br/><br/>
                        <textarea class="form-control form-material" name="remarks" rows="3"></textarea>
                        <a class="mytooltip pull-right" href="javascript:void(0)"> what's this?
                            <span class="tooltip-content5">
                                <span class="tooltip-text3">
                                    <span class="tooltip-inner2">To Delete, <br/> Please enter the reason why this course is being deleted.</span>
                                </span>
                            </span>
                        </a>
                        <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">undo, undo!</button>
                        <button class="btn btn-danger text-uppercase submit">continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /delete course -->

    <!-- update course -->
    <div class="modal fade update-course" tabindex="-1" role="dialog" aria-labelledby="updateCourseLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="updateCourseLabel">confirm action</h4> </div>
                <form action="{{ route('courses.update', $course->id) }}" method="post">
                    {{ csrf_field() }} {{ method_field('put') }}
                    <input type="text" class="hidden" name="redirect_path" value="{{ route('courses.show', $course->id) }}" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code" class="control-label">Code *</label>
                            <input class="form-control code" type="text" id="code" name="code" value="{{ $course->code }}" />
                            <p class="text-muted m-t-5">i.e. <b>bosiet</b></p>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Description *</label>
                            <input class="form-control description" type="text" id="description" name="description" value="{{ $course->description }}" />
                            <p class="text-muted m-t-5">i.e. <b>basic offshore safety induction and emergency training</b></p>
                        </div>
                        <div class="form-group">
                            <label for="category" class="control-label">Category *</label>
                            <select class="form-control text-uppercase" name="category" id="category">
                                <option class="text-uppercase" value="common" {{ $course->category == 'common'? 'selected' : '' }}>common</option>
                                <option class="text-uppercase" value="deck" {{ $course->category == 'deck'? 'selected' : '' }}>deck</option>
                                <option class="text-uppercase" value="engine" {{ $course->category == 'engine'? 'selected' : '' }}>engine</option>
                                <option class="text-uppercase" value="off-shore" {{ $course->category == 'off-shore'? 'selected' : '' }}>off-shore</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="accreditation_body" class="control-label">Accreditation Body *</label>
                            <select class="form-control text-uppercase" name="accreditation_body" id="accreditation_body">
                                <option class="text-uppercase" value="marina" {{ $course->accreditation_body == 'marina'? 'selected' : '' }}>marina</option>
                                <option class="text-uppercase" value="opito" {{ $course->accreditation_body == 'opito'? 'selected' : '' }}>opito</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duration" class="control-label">Duration *</label>
                            <input class="form-control duration" type="number" id="duration" name="duration" value="{{ $course->duration }}" placeholder="Please enter duration in days" />
                            <p class="text-muted m-t-5">i.e. <b>6</b></p>
                        </div>
                        <div class="form-group">
                            <label for="aims" class="control-label">Aims <b class="text-info">(optional)</b></label>
                            <textarea class="form-control" name="aims" id="aims" rows="3">{{ $course->aims }}</textarea>
                            <p class="text-muted m-t-5">i.e. <b>The aim of the Escape Chute Refresher Training programme is to ensure delegates maintain their knowledge and skills in the use of escape chutes as a means of tertiary escape from offshore installations and vessels.</b></p>
                        </div>
                        <div class="form-group">
                            <label for="objectives_header" class="control-label">Objectives Header <b class="text-info">(optional)</b></label>
                            <textarea class="form-control" name="objectives_header" id="objectives_header" rows="3">{{ $course->objectives_header }}</textarea>
                            <p class="text-muted m-t-5">i.e. <b>To update and maintain knowledge and skills in the following:</b></p>
                        </div>
                        <div class="form-group">
                            <label for="objectives" class="control-label">Objectives <b class="text-info">(optional)</b></label>
                            <textarea class="form-control" name="objectives" id="objectives" rows="3">{{ $course->objectives }}</textarea>
                            <p class="text-muted m-t-5">i.e. <b>To make delegates aware of the various types of escape chutes used on offshore installations and vessels To provide theoretical and practical training in the safe techniques for escaping through an escape chute To ensure delegates understand what they are required to do when exiting the escape chute </b></p>
                        </div>
                        <div class="form-group">
                            <label for="prerequisites" class="control-label">Prerequisites <b class="text-info">(optional)</b></label>
                            <textarea class="form-control" name="prerequisites" id="prerequisites" rows="3">{{ $course->prerequisites }}</textarea>
                            <p class="text-muted m-t-5">i.e.<br><b>Medical Certificate<br>Valid OPITO approved Escape Chute Training or Refresher Training certificate.</b></p>
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="control-label">Remarks *</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="3">{{ old('remarks') }}</textarea>
                            <p class="text-muted m-t-5"><b>Remarks is required for updating course details.</b></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /update course -->

    <!-- restore course -->
    <div class="modal fade restore-course" tabindex="-1" role="dialog" aria-labelledby="restoreCourseLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="restoreCourseLabel">confirm action</h4> </div>
                <form action="{{ route('courses.restore', $course->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        Restoring a course requires <b class="text-uppercase text-info">remarks</b> for future reference. <br/><br/>
                        <textarea class="form-control form-material" name="remarks" rows="3"></textarea>
                        <a class="mytooltip pull-right" href="javascript:void(0)"> what's this?
                            <span class="tooltip-content5">
                                <span class="tooltip-text3">
                                    <span class="tooltip-inner2">To Restore, <br/> Please enter the reason why this course is being restored.</span>
                                </span>
                            </span>
                        </a>
                        <br/>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">undo, undo!</button>
                        <button class="btn btn-danger text-uppercase submit">continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /restore course -->

    <!-- /modals -->
@stop
@section('page-scripts')
    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>
    <!-- Sweet-Alert  -->
    <script src="{{ asset('/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Datatable -->
    <script src="{{ asset('/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(function () {
            $('#history_table').DataTable({
                'aaSorting' : []
            });

            $("#print").click(function () {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode
                    , popClose: close
                };
                $("div.printableArea").printArea(options);
            });

            $('.money-mask').mask('000,000,000.00', {reverse: true});

            // highlight workaround start
            function removeHighlight() {
                $('#home-sidebar').removeClass('active')
            }

            setTimeout(removeHighlight, 100)
            // highlight workaround end

            $('#code, #description').on('keyup', function () {
                $(this).val($(this).val().toLowerCase())
            })
        })
    </script>
@stop