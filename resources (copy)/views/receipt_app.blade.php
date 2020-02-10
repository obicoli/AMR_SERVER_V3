
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keyword" content="Hospital, Appointment, System, Hospital Appointment,Clinic, Pharmacy" />
    <meta name="description" content="Find easily a doctor and book online an appointment, video consultation, order medicine, find nearby clinics/hospitals" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{URL::asset('/assets/images/icons/a78e675b979178da3cfa63577289aea0.png')}}"/>
    <title>:: {{ config('app.name') }} :: Welcome</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{URL::asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Jquery Ui -->
    <link href="{{URL::asset('/assets/css/jquery-ui.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome -->
    <link href="{{URL::asset('/assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Flaticon -->
    <link href="{{URL::asset('/assets/css/flaticon.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Owl Carousel -->
    <link href="{{URL::asset('/assets/owl-carousel/owl.carousel.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/assets/owl-carousel/owl.theme.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/assets/owl-carousel/owl.transitions.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Custom Style Sheet -->
    <link href="{{URL::asset('/assets/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('/assets/css/custom.css')}}" rel="stylesheet" type="text/css"/>
<!--    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">-->
</head>

    <body id="page-top">

        @yield('content')

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{URL::asset('/assets/js/jquery.min.js')}}" type="text/javascript"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{URL::asset('/assets/js/bootstrap.min.js')}}"></script>
        <!-- owl carousel js -->
        <script src="{{URL::asset('/assets/owl-carousel/owl.carousel.min.js')}}" type="text/javascript"></script>
        <!-- Plugin JavaScript -->
        <script src="{{URL::asset('/assets/js/jquery.easing.min.js')}}" type="text/javascript"></script>
        <!-- Jquery Ui -->
        <script src="{{URL::asset('/assets/js/jquery-ui.min.js')}}" type="text/javascript"></script>
        <!-- Custom Js -->
        <script src="{{URL::asset('/assets/js/custom.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

    </body>

</html>

<!--https://medix.spantiklab.com/return_items PHARMACY-->
<!--https://medix.spantiklab.com/main PHARMACY-->
<!--http://ideal.thesoftking.com/pharma/login PHARMACY-->
