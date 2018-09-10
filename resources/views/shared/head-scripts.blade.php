<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Companion 2Go</title>

<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{ asset('css/skins/_all-skins.min.css') }}">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<!-- Google Maps -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQd8ifFv5_cNqRZ0oFtizulSNbruyuFas&libraries=places"></script>

<!-- jQuery -->
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>

<!-- jQuery UI -->
<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>

<!-- Chart.js -->
<script type="text/javascript" src="{{ asset('js/raphael.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/morris.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/morris.css') }}">

<!-- Color picker -->
<script type="text/javascript" src="{{ asset('js/bootstrap-colorpicker.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/bootstrap-colorpicker.min.css') }}">

<!-- Moment JS -->
<script type="text/javascript" src="{{ asset('js/moment-with-locales.js') }}"></script>

<!-- Datetime picker -->
<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">

<!-- Trumbowyg -->
<link rel="stylesheet" href="https://cdn.rawgit.com/Alex-D/Trumbowyg/v2.9.2/dist/ui/trumbowyg.min.css">
<script type="text/javascript" src="https://cdn.rawgit.com/Alex-D/Trumbowyg/v2.9.2/dist/trumbowyg.min.js"></script>

<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<script type="text/javascript" src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>

<!-- Project JS -->
<script type="text/javascript" src="{{ asset('js/main.js') }}" defer></script>