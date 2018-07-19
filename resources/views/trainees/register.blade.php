<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('plugins/images/logo_nscpi.png') }}">
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
                <div class="lg-content">
                    <h2>NEWSIM ONLINE RESERVATION SYSTEM</h2>
                    <p class="text-muted">Already have an account? Click sign in button below instead!</p>
                    <form action="{{ route('trainee.login') }}" method="get">
                        <button class="btn btn-rounded btn-danger p-l-20 p-r-20 text-uppercase">sign in</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="new-login-box">
            <div class="white-box">
                <h3 class="box-title m-b-0">Sign UP now to reserve a schedule!</h3>
                @if($errors->any())
                    <br/>
                    <ul class="common-list">
                    @foreach($errors->all() as $error)
                    <li><i class="ti ti-close text-danger"></i> {{ $error }}</li>
                    @endforeach
                    </ul>
                @endif
                <form class="form-horizontal new-lg-form" id="loginform" action="{{ route('trainee.signup') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="col-xs-12">
                            <h4>Log in credentials</h4>
                            <hr/>
                            <input class="form-control" type="text" placeholder="Username *" name="username" value="{{ old('username') }}" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" placeholder="Password *" name="password" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h4>Trainee Personal Information</h4>
                            <hr/>
                            <input class="form-control" type="email" placeholder="Valid Email Address *" name="email" value="{{ old('email') }}" />
                            <small class="text-muted">Please enter a valid email address, this will be used to send confirmation messages of your reservations.</small>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" placeholder="First Name *" name="first_name" value="{{ old('first_name') }}" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" placeholder="Middle Name *" name="middle_name" value="{{ old('middle_name') }}" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" placeholder="Last Name *" name="last_name" value="{{ old('last_name') }}" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control mobile-number-mask" type="text" placeholder="Mobile Number *" name="mobile_number" value="{{ old('mobile_number') }}" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" placeholder="Telephone Number" name="telephone_number" value="{{ old('telephone_number') }}" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <select name="rank" class="selectpicker form-control" data-live-search="true">
                                <option value="" class="hidden">Select trainee rank *</option>
                                <option value="cadet" {{ old('rank') == 'cadet'? 'selected' : '' }}>Cadet</option>
                                <option value="chef" {{ old('rank') == 'chef'? 'selected' : '' }}>Chef</option>
                                <option value="engineer" {{ old('rank') == 'engineer'? 'selected' : '' }}>Engineer</option>
                                <option value="master" {{ old('rank') == 'master'? 'selected' : '' }}>Master</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <select name="gender" class="selectpicker form-control">
                                <option value="" class="hidden">Select gender *</option>
                                <option value="female" {{ old('gender') == 'female'? 'selected' : '' }}>Female</option>
                                <option value="male" {{ old('gender') == 'male'? 'selected' : '' }}>Male</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <textarea name="address" rows="3" class="form-control" placeholder="Address *">{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control date-mask" type="text" placeholder="Birth date *" name="birth_date" value="{{ old('birth_date') }}" />
                            <p class="text-mutd">Please use the format YYYY-MM-DD i.e. 1990-06-24</p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" placeholder="Company" name="company" value="{{ old('company') }}" />
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
    <!-- masked input -->
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>

    <script>
        $('.date-mask').mask('0000-00-00');
        $('.mobile-number-mask').mask('+63900-0000-000');
    </script>
</body>
</html>