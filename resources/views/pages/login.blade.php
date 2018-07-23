<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('plugins/images/logo_nscpi.png') }}">
    <title>NEWSIM Online Reservation System</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('css/colors/green.css') }}" id="theme"  rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
    <div class="login-box login-sidebar">
        <div class="white-box">
            <form class="form-horizontal form-material" id="loginform" action="{{ route('login.authenticate') }}" method="post">
                {{ csrf_field() }}
                <a href="javascript:void(0)" class="text-center db"><img src="{{ asset('/images/newsim_logo.jpg') }}" alt="Home" width="250" height="50"/><br/><h2 class="text-uppercase text-info"><b>reservation system</b></h2></a>

                <div class="form-group m-t-40">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" placeholder="Username" name="username">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" placeholder="Password" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        {{--<div class="checkbox checkbox-primary pull-left p-t-0">--}}
                            {{--<input id="checkbox-signup" type="checkbox">--}}
                            {{--<label for="checkbox-signup"> Remember me </label>--}}
                        {{--</div>--}}
                        <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        <p>Don't have an account? <a href="#" class="text-primary m-l-5" id="request-account"><b>Request for an account</b></a></p>
                    </div>
                    @if(count($errors) > 0)
                    <div class="col-sm-12 text-center">
                        <p class="text-danger"><b>Whoops! You must have missed something! Click <a class="text-info" href="#" id="with-error">here</a> to check what it is.</b></p>
                    </div>
                    @elseif(session('info.success'))
                    <div class="col-sm-12 text-center">
                        <p class="text-info">{{ session('info.success') }}</p>
                    </div>
                    @endif
                </div>
            </form>
            <form class="form-horizontal" id="recoverform" action="index.html">
                <div class="form-group ">
                    <div class="col-xs-12">
                        <h3>Recover Password</h3>
                        <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" placeholder="Email">
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                    </div>
                    <div class="col-xs-12 m-t-10">
                        <button class="btn btn-danger btn-lg btn-block text-uppercase waves-effect waves-light" id="btn-cancel" type="button">Cancel</button>
                    </div>
                </div>
            </form>
            <form class="form-horizontal" id="requestaccountform" action="{{ route('administrators.store') }}" style="display: none; height: 95vh; overflow-y: auto; overflow-x: hidden" method="post">
                @csrf
                <div class="form-group ">
                    <div class="col-xs-12">
                        <h3>Request for an Account</h3>
                        <p class="text-muted">Enter provide the needed information and wait for the administrators to validate your request. </p>
                        <ul class="common-list">
                            @foreach($errors->all() as $error)
                                <li><i class="ti ti-close text-danger"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" placeholder="Username *" name="username" value="{{ old('username') }}">
                    </div>
                    <div class="col-xs-12 m-t-10">
                        <input class="form-control" type="text" placeholder="Email *" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="col-xs-12 m-t-10">
                        <input class="form-control" type="password" placeholder="Password *" name="password">
                    </div>
                    <div class="col-xs-12 m-t-10">
                        <input class="form-control" type="password" placeholder="Confirm Password *" name="password_confirmation">
                    </div>
                    <div class="col-xs-12 m-t-10">
                        <input class="form-control" type="text" placeholder="Full Name *" name="full_name" value="{{ old('full_name') }}">
                    </div>
                    <div class="col-xs-12 m-t-10">
                        <input class="form-control" type="text" placeholder="Employee ID *" name="employee_id" value="{{ old('employee_id') }}">
                    </div>
                    <div class="col-xs-12 m-t-10">
                        <select name="branch_id" class="form-control">
                            <option value="" hidden>Select Your Branch *</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $branch->id == old('branch_id')? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-12 m-t-10">
                        <select name="department_id" class="form-control">
                            <option value="" hidden>Select Your Department *</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ $department->id == old('department_id')? 'selected' : '' }}>{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-12 m-t-10">
                        <select name="position_id" class="form-control">
                            <option value="" hidden>Select Your Position *</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ $position->id == old('position_id')? 'selected' : '' }}>{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-12 m-t-10">
                        <textarea class="form-control" name="reason" rows="5" placeholder="Reason for Requesting Account *">{{ old('reason') }}</textarea>
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Submit</button>
                    </div>
                    <div class="col-xs-12 m-t-10">
                        <button class="btn btn-danger btn-lg btn-block text-uppercase waves-effect waves-light" id="btn-cancel-request" type="button">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- jQuery -->
<script src="{{ asset('../plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{ asset('../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>

<!--slimscroll JavaScript -->
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('js/waves.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('js/custom.min.js') }}"></script>
<!--Style Switcher -->
<script src="{{ asset('../plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>

<script>
    $('#btn-cancel').on('click', function () {
        $('#loginform').slideDown()
        $('#recoverform').fadeOut()
    })


    $('#btn-cancel-request').on('click', function () {
        $('#loginform').slideDown()
        $('#requestaccountform').fadeOut()
    })

    $('#request-account, #with-error').on('click', function () {
        $('#loginform').slideUp()
        $('#requestaccountform').fadeIn()
    })
</script>
</body>
</html>
