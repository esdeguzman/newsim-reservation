@extends('layouts.main')
@section('page-tab-title') Courses @stop
@section('active-page')
    <li><a href="{{ route('courses.index') }}"><b class="text-info">Courses</b></a></li>
    <li class="active"><span class="text-muted text-uppercase">bosiet</span></li>
@stop
@section('page-short-description') @stop
@section('page-content')
    <div class="col-md-12 block3">
        <div class="white-box printableArea">
            <button class="pull-right text-uppercase btn btn-info"  data-toggle="modal" data-target=".update-course">update course details</button>
            <h3 class="text-uppercase">bosiet <span class="tooltip-item2"><small>basic offshore safety induction and emergency training</small></span></h3>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left"> <address>
                            <h1> &nbsp;<b class="text-uppercase">P 3,000.00</b><sup><small>original price</small></sup></h1>
                        </address> </div>
                    <div class="pull-right text-right"> <address>
                            <p class="m-t-30"><button class="text-uppercase btn btn-danger" data-toggle="modal" data-target=".update-original-price">amend original price</button>
                            {{--<p><b>Reservation Date :</b> <i class="fa fa-calendar"></i> May 31, 2018</p>--}}
                            {{--<p><b class="text-danger">Expiration Date :</b> <i class="fa fa-calendar"></i> June 1, 2018</p>--}}
                        </address> </div>
                </div>
                <div class="col-md-12 m-t-40">
                    <div class="table-responsive" style="clear: both;">
                        <h3 class="text-uppercase"><code>timeline</code></h3>
                        <p class="text-muted">This shows important events happened to this schedule like <code class="text-uppercase">original price</code> changes and more!</p>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Event</th>
                                <th>Blame</th>
                                <th>Date Amended</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-uppercase">
                                    updated <code>original price</code> from <code>P 2,500.00</code> to <code>P 3,000.00</code>
                                </td>
                                <td class="text-uppercase">marketing officer</td>
                                <td class="text-uppercase">june 24, 2018</td>
                                <td class="text-uppercase">as per department advise</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-5 col-sm-5 pull-right m-t-40">
                    <div class="panel panel-danger">
                        <div class="panel-heading"> Danger Zone
                            <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
                        </div>
                        <div class="panel-wrapper collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <p>This will <b class="text-danger text-uppercase">permanently delete this course and all the history above</b>. <br/><br/>
                                    This panel is <b class="text-info text-uppercase">purposely closed by default</b>, if you are reading this,
                                    and <b class="text-danger text-uppercase">still continue to delete this course</b>; a log will be saved tagging you
                                    as the sole administrator that is <b class="text-info text-uppercase">responsible for this deletion</b>.
                                </p> <br/><br/>
                                <button class="btn btn-block btn-danger text-uppercase"  data-toggle="modal" data-target=".delete-course">i understand, proceed course deletion</button>
                            </div>
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
                <form action="#">
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
                            <label for="code">Code</label>
                            <input type="text" class="form-control form-material" name="code" id="code" value="bosiet" />
                        </div>
                        <div class="form-group">
                            <label for="code">Description</label>
                            <input type="text" class="form-control form-material" name="description" id="description" value="basic offshore safety induction and emergency training" />
                        </div>
                        <p class="text-muted m-t-15">All schedules and reservations associated with this course will also be affected.</p>
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
                <form action="#">
                    <div class="modal-body">
                        <label for="value">Original Price</label>
                        <input type="text" class="form-control form-material money-mask" name="value" id="value" value="300000" />
                        <p class="text-muted m-t-5">Only <b class="text-info">new reservations</b> will be affected by this price update.</p>
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

    <!-- /modals -->
@stop
@section('page-scripts')
    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>
    <!-- Sweet-Alert  -->
    <script src="{{ asset('/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(function () {
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

            $('#code, #description').on('keyup', function() {
                $(this).val( $(this).val().toLowerCase() )
            })
        });
    </script>
@stop