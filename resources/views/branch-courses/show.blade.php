@extends('layouts.main')
@section('page-tab-title') Courses @stop
@section('page-specific-link') <link href="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" /> @stop
@section('active-page')
    <li><a href="{{ route('branch-courses.index') . '?filter=all_branches' }}"><b class="text-info">Courses</b></a></li>
    <li><span class="text-uppercase"><a href="{{ route('branch-courses.index') . '?branch=' . $branchCourse->branch->name }}"><b class="text-info">{{ $branchCourse->branch->name }}</b></a></span></li>
    <li class="active"><span class="text-muted text-uppercase">{{ $branchCourse->details->code }}</span></li>
@stop
@section('branch-courses-sidebar-menu') active @stop
@section('page-short-description') @stop
@section('page-content')
    <div class="col-md-12 block3">
        <div class="white-box printableArea">
            <button class="pull-right text-uppercase btn btn-info"  data-toggle="modal" data-target=".update-course">update course details</button>
            <h3 class="text-uppercase">{{ $branchCourse->details->code }} <span class="tooltip-item2"><small>{{ $branchCourse->details->description }}</small></span></h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">
                        <address>
                            @if(isset($originalPrice)) <h1> &nbsp;<b class="text-uppercase">P {{ number_format($originalPrice->value, 2) }}</b><sup><small>original price</small></sup></h1>
                            @else <h1><a class="text-uppercase btn btn-success" data-toggle="modal" data-target=".set-original-price">set original price</a></h1>
                            @endif
                        </address>
                    </div>
                    <div class="pull-right text-right"> <address>
                            @if(isset($originalPrice)) <p class="m-t-30"><a class="text-uppercase btn btn-info" data-toggle="modal" data-target=".update-original-price" data-original-price="{{ $originalPrice->value }}" data-original-price-id="{{ $originalPrice->id }}" id="update_original_price">amend original price</a></p>
                            @endif
                            {{--<p><b>Reservation Date :</b> <i class="fa fa-calendar"></i> May 31, 2018</p>--}}
                            {{--<p><b class="text-danger">Expiration Date :</b> <i class="fa fa-calendar"></i> June 1, 2018</p>--}}
                        </address> </div>
                </div>
                <div class="col-md-12 m-t-40">
                    <div class="table-responsive" style="clear: both;">
                        <h3 class="text-uppercase"><code>timeline</code></h3>
                        <p class="text-muted">This shows important events happened to this schedule like <code class="text-uppercase">original price</code> changes and more!</p>
                        <table class="table table-hover table-striped" id="history_table">
                            <thead>
                            <tr>
                                <th>Log</th>
                                <th>Remarks</th>
                                <th>Blame</th>
                                <th>Date Amended</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($branchCourse->details->hasHistory())
                                @foreach($branchCourse->details->history() as $history)
                                    <tr>
                                        <td class="text-uppercase">{{ $history->log }}</td>
                                        <td class="text-uppercase">{{ $history->remarks }}</td>
                                        <td class="text-uppercase">{{ $history->updatedBy->full_name }}</td>
                                        <td class="text-uppercase">{{ Carbon\Carbon::parse($history->created_at)->toFormattedDateString() }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            @if(optional($originalPrice)->hasHistory())
                                @foreach($originalPrice->history() as $history)
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
                <div class="col-lg-5 col-sm-5 pull-right m-t-40">
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
                                </p> <br/><br/>
                            </div>
                            <button class="btn btn-block btn-danger text-uppercase"  data-toggle="modal" data-target=".delete-course">i understand, proceed course deletion</button>
                        </div>
                    </div>
                </div>
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
                <form action="{{ route('branch-courses.destroy', $branchCourse->id) }}" method="post">
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
                <form action="#">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code">What do you want to change?</label>
                            <textarea name="change_request" id="change_request" rows="3" class="form-control"></textarea>
                        </div>
                        <p class="text-muted m-t-15">State what you want to change and why it has to be changed. ie: "Please change the code to XZY because ***". Because
                            changing course details will affect all branches with the same course, a review will have to take effect first from the central branch.</p>
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

    <!-- update original price -->
    <div class="modal fade update-original-price" tabindex="-1" role="dialog" aria-labelledby="updateOriginalPriceLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="updateOriginalPriceLabel">confirm action</h4> </div>
                <form action="#" id="update_original_price_form" method="post">
                    @csrf @method('put')
                    <input type="number" name="branch_course_id" value="{{ $branchCourse->id }}" hidden />
                    <input type="number" name="updated_by" value="{{ auth()->user()->id }}" hidden />
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="value">Original Price</label>
                            <input type="text" class="form-control form-material money-mask" name="value" id="update_value" />
                            <p class="text-muted m-t-5">Only <b class="text-info">new reservations</b> will be affected by this price update.</p>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="3" class="form-control"></textarea>
                            <p class="text-muted m-t-5">Please state any reference that can backup this original price update</p>
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
    <!-- /update original price -->

    <!-- set original price -->
    <div class="modal fade set-original-price" tabindex="-1" role="dialog" aria-labelledby="setOriginalPriceLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase" id="setOriginalPriceLabel">confirm action</h4> </div>
                <form action="{{ route('original-prices.store') }}" method="post">
                    {{ csrf_field() }}
                    <input type="number" name="branch_course_id" value="{{ $branchCourse->id }}" hidden />
                    <input type="number" name="added_by" value="{{ auth()->user()->id }}" hidden />
                    <div class="modal-body">
                        <label for="value">Original Price</label>
                        <input type="text" class="form-control form-material money-mask" name="value" id="value" />
                        <p class="text-muted m-t-5">Only <b class="text-info">new reservations</b> will be affected by this price update.</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info text-uppercase" data-dismiss="modal">cancel</button>
                        <button class="btn btn-danger text-uppercase submit">set original price</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /set original price -->

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

            $('#update_original_price').on('click', function () {
                let originalPriceUpdateUrl = '{{ url("admin/original-prices/") }}' + '/' + $(this).data('original-price-id')
                let value = $(this).data('original-price')

                $('#update_value').val(value)
                $('#update_original_price_form').attr('action', originalPriceUpdateUrl)
            })
        });
    </script>
@stop