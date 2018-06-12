<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('plugins/images/favicon.png') }}">
    <title>NEWSIM Reservation | Trainee registration</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('css/colors/megna-dark.css') }}" id="theme" rel="stylesheet">
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
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
        </svg>
    </div>
    <section id="wrapper" class="new-login-register" style="height: 100vh; overflow-y: auto">
        <div class="lg-info-panel">
            <div class="inner-panel">
                <a href="javascript:void(0)" class="p-20 di"><img src="{{ asset('plugins/images/admin-logo.png') }}"></a>
                <div class="lg-content">
                    <h2>NEWSIM ONLINE RESERVATION SYSTEM</h2>
                    <p class="text-muted">Already have an account? Click sign in button below instead!</p>
                    <form action="{{ route('trainee-login') }}" method="get">
                        <button class="btn btn-rounded btn-danger p-l-20 p-r-20 text-uppercase">sign in</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="new-login-box">
            <div class="white-box">
                <h3 class="box-title m-b-0">Sign UP now to reserve a schedule!</h3>
                <form class="form-horizontal new-lg-form" id="loginform" action="index.html">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <h4>Log in credentials</h4>
                            <hr/>
                            <input class="form-control" type="text" required="" placeholder="Username *" name="username" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="Password *" name="password" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h4>Trainee Personal Information</h4>
                            <hr/>
                            <input class="form-control" type="email" required="" placeholder="Valid Email Address *" name="email" />
                            <small class="text-muted">Please enter a valid email address, this will be used to send confirmation messages of your reservations.</small>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="First Name *" name="first_name" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Middle Name *" name="middle_name" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Last Name *" name="last_name" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Mobile Number *" name="mobile_number" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Telephone Number" name="telephone_number" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <select name="rank" class="selectpicker form-control" data-live-search="true">
                                <option value="" class="hidden">Select trainee rank *</option>
                                <option value="cadet">Cadet</option>
                                <option value="chef">Chef</option>
                                <option value="engineer">Engineer</option>
                                <option value="master">Master</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <select name="rank" class="selectpicker form-control">
                                <option value="" class="hidden">Select gender *</option>
                                <option value="female">Female</option>
                                <option value="male">Male</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <textarea name="address" rows="3" class="form-control" placeholder="Address *"></textarea>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Birth date *" name="birth_date" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Company" name="company" />
                        </div>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div class="checkbox checkbox-primary p-t-0">--}}
                                {{--<input id="checkbox-signup" type="checkbox">--}}
                                {{--<label for="checkbox-signup"> I agree to all <a href="#">Terms</a></label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- jQuery -->
    <script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('js/waves.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <!--Style Switcher -->
    <script src="{{ asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>
</body>

</html>