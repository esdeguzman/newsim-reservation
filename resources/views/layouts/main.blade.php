<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('plugins/images/logo_nscpi.png') }}">
    <title>NEWSIM Online Reservation System | @yield('page-tab-title', 'Home')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!--alerts CSS -->
    <link href="{{ asset('/plugins/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <!-- Menu CSS -->
    <link href="{{ asset('/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('css/colors/megna-dark.css') }}" id="theme" rel="stylesheet">
    @yield('page-specific-link')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="fix-header">
<!-- ============================================================== -->
<!-- Preloader -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
<!-- ============================================================== -->
<!-- Wrapper -->
<!-- ============================================================== -->
<div id="wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <div class="top-left-part">
                <!-- Logo -->
                <a class="logo" href="index.html">
                    <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon--><img src="{{ asset('/images/logo_nscpi.png') }}" alt="home" class="dark-logo" width="33" height="31" /><!--This is light logo icon--><img src="{{ asset('/images/logo_nscpi.png') }}" alt="home" class="light-logo" width="33" height="31" />
                    </b>
                    <!-- Logo text image you can use text also --><span class="hidden-xs">
                        <!--This is dark logo text--><img src="{{ asset('/images/newsim_brand.png') }}" alt="home" class="dark-logo" width="139" height="24" /><!--This is light logo text--><img src="{{ asset('/images/newsim_brand.png') }}" alt="home" class="light-logo" width="139" height="24" />
                     </span> </a>
            </div>
            <!-- /Logo -->
            <!-- Search input and Toggle icon -->
            <ul class="nav navbar-top-links navbar-left">
                <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="fa fa-tags"></i>
                        <div class="notify"> @yield('new-reservations-pulse') </div> <!-- NOTE: USE THIS CODE WHEN THERE ARE NEW NOTIFICATIONS <span class="heartbit"></span> <span class="point"></span> -->
                    </a>
                    <ul class="dropdown-menu mailbox animated bounceInDown">
                        <li>
                            <div class="drop-title">There are @yield('new-reservations-count', 'no') new reservations</div>
                        </li>
                        <li>
                            <div class="message-center">
                                {{--<a href="#">--}}
                                    {{--<div class="user-img"> <img src="{{ asset('../plugins/images/users/pawandeep.jpg')}}" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>--}}
                                    {{--<div class="mail-contnet">--}}
                                        {{--<h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>--}}
                                {{--</a>--}}
                            </div>
                        </li>
                        {{--<li>--}}
                            {{--<a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>--}}
                        {{--</li>--}}
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="fa fa-thumbs-up"></i>
                        <div class="notify"> @yield('confirmed-reservation-pulse') </div> <!-- NOTE: USE THIS CODE WHEN THERE ARE NEW NOTIFICATIONS <span class="heartbit"></span> <span class="point"></span> -->
                    </a>
                    <ul class="dropdown-menu mailbox animated bounceInDown">
                        <li>
                            <div class="drop-title">There are @yield('confirmed-reservations-count', 'no') confirmed reservations</div>
                        </li>
                        <li>
                            <div class="message-center">
                                {{--<a href="#">--}}
                                {{--<div class="user-img"> <img src="{{ asset('../plugins/images/users/pawandeep.jpg')}}" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>--}}
                                {{--<div class="mail-contnet">--}}
                                {{--<h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>--}}
                                {{--</a>--}}
                            </div>
                        </li>
                        {{--<li>--}}
                        {{--<a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>--}}
                        {{--</li>--}}
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
            </ul>
            <ul class="nav navbar-top-links navbar-right pull-right">
                {{--<li>--}}
                    {{--<form role="search" class="app-search hidden-sm hidden-xs m-r-10">--}}
                        {{--<input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>--}}
                {{--</li>--}}
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="{{ asset('../plugins/images/users/varun.jpg') }}" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">@yield('username', 'ESME')</b><span class="caret"></span> </a>
                    <ul class="dropdown-menu dropdown-user animated flipInY">
                        <li>
                            <div class="dw-user-box">
                                <div class="u-img"><img src="{{ asset('../plugins/images/users/varun.jpg') }}" alt="user" /></div>
                                <div class="u-text"><h4>@yield('full-name', 'Esmeraldo de Guzman Jr')</h4><p class="text-muted">@yield('email', 'deguzman.esmeraldo@gmail.com')</p>
                                    <a href="profile.html" class="btn btn-rounded btn-info btn-sm">View Profile</a>
                                    <a href="profile.html" class="btn btn-rounded btn-danger btn-sm">Log out</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>

                <!-- /.dropdown -->
            </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- End Top Navigation -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav slimscrollsidebar">
            <div class="sidebar-head">
                <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
            <ul class="nav" id="side-menu">
                <li><a href="{{ url('home') }}" class="waves-effect @yield('home-sidebar-menu')" id="home-sidebar"><i class="mdi mdi-home fa-fw"></i> <span class="hide-menu">Home</span></a></li>
                <li><a href="{{ route('courses.index') }}" class="waves-effect @yield('courses-sidebar-menu')" id="courses-sidebar"><i class="fa fa-book"></i> <span class="hide-menu">&nbsp;&nbsp;&nbsp;Courses</span></a></li>
                <li><a href="{{ route('schedules.index') }}" class="waves-effect @yield('schedules-sidebar-menu')" id="schedules-sidebar"><i class="fa fa-calendar"></i> <span class="hide-menu">&nbsp;&nbsp;&nbsp;Schedules</span></a></li>
                <li><a href="{{ route('reservations.index') }}" class="waves-effect @yield('reservations-sidebar-menu')" id="reservations-sidebar"><i class="fa fa-tags"></i> <span class="hide-menu">&nbsp;&nbsp;&nbsp;Reservations</span></a></li>
                <li class="divider"></li>
                <li> <a href="#" class="waves-effect @yield('user-management-sidebar-menu')" id="user-management-sidebar"><i class="fa fa-users" data-icon="v"></i> <span class="hide-menu">&nbsp;&nbsp;&nbsp;User Management <span class="fa arrow"></span> <!-- <span class="label label-rouded label-inverse pull-right">4</span> --> </span></a>
                    <ul class="nav nav-second-level">
                        <li> <a href="{{ route('administrators.index') }}"><i class=" fa-fw">&#10095;</i><span class="hide-menu">Administrator</span></a> </li>
                        <li> <a href="{{ route('trainees.index') }}"><i class=" fa-fw">&#10095;</i><span class="hide-menu">Trainees</span></a> </li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a href="{{ url('/') }}" class="waves-effect" id="logout-sidebar"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Log out</span></a></li>
            </ul>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Left Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                    <h4 class="page-title">@yield('page-short-description', 'NEWSIM Online Reservation System')</h4> </div>
                <div class="col-lg-6 col-sm-5 col-md-5 col-xs-12">
                    <ol class="breadcrumb">
                        @section('active-page')
                            <li class="active">Home</li>
                        @show
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                @section('page-content')
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title text-center">Welcome to NEWSIM Online Reservation System!</h3>
                        </div>
                    </div>
                @show
            </div>
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center"> 2018 &copy; NEWSIM Online Reservation System </footer>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
</div>
<!-- /#wrapper -->
<!-- jQuery -->
<script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
<!--slimscroll JavaScript -->
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('js/waves.js')}}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('js/custom.min.js') }}"></script>
<!-- masked input -->
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<!--Style Switcher -->
<script src="{{ asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>
<!--BlockUI Script -->
<script src="{{ asset('plugins/bower_components/blockUI/jquery.blockUI.js') }}"></script>

@yield('page-scripts')

<script>
    // highlight workaround start
    function removeHighlight() {
        $('#logout-sidebar').removeClass('active')
    }

    setTimeout(removeHighlight, 100)
    // highlight workaround end
</script>
</body>

</html>