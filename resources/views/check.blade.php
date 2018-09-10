<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Companion 2Go</title>

    <!-- Bootstrap core CSS -->
    <link href="/check/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <link href="/check/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/check/vendor/devicons/css/devicons.min.css" rel="stylesheet">
    <link href="/check/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/check/css/resume.css?_=<?php echo time(); ?>" rel="stylesheet">

</head>

<body id="mainApp">

<nav class="js_navbar navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Companion 2Go</a>
    <button class="js_login btn btn-outline-success my-2 mx-2 my-sm-0" >Login</button>
    <button class="js_register btn btn-outline-info my-2 mx-2 my-sm-0" >Register</button>
    <button class="js_profile btn btn-outline-info my-2 mx-2 my-sm-0" >Profile</button>
</nav>

<div id="mainContainer" class="container mt-2 p-2">
</div>

<div id="errorsContainer" class="container mt-4">
    <div class="alert alert-danger" role="alert"></div>
</div>

<div class="container view" id="view_profile">
        <div class="card text-center">
            <div class="card-header">
                Profile
            </div>
            <div class="card-block p-2">
                <h4 class="card-title">Hello, <span class="js_first_name"></span> <span class="js_last_name"></span></h4>
                <p class="card-text">Email: <span class="js_email"></span></p>

                <form class="js_if_podcast_empty display_none">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <select id="profile_podcast_id" class="form-control" name="podcast_id">
                                    <option value="">Please choose podcast</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="alert alert-info js_if_podcast_empty display_none" role="alert">
                    You need to choose your Podcast to continue
                </div>

                <p class="card-text js_if_podcast_present display_none">Podcast: <span class="js_podcast"></span></p>

                <a href="#" class="btn btn-success js_if_podcast_empty display_none js_save_podcast">Save podcast info</a>

                <a href="#" class="btn btn-primary js_logout">Logout</a>
            </div>
        </div>
</div>

<div class="container view" id="view_register">
    <h2>Please Register</h2>
    <form class="form-horizontal" role="form" method="POST" action="">
        <div class="row">
            <div class="col">
                <div class="form-group has-danger">
                    <div class="input-group">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                        <input type="text" name="email" class="form-control" id="registration_email" placeholder="Your email" required autofocus>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group has-danger">
                    <div class="input-group">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                        <input type="password" name="password" class="form-control" id="registration_password" placeholder="Your password" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group has-danger">
                    <div class="input-group">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-info-circle"></i></div>
                        <input type="text" name="first_name" class="form-control" id="registration_first_name" placeholder="First name" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group has-danger">
                    <div class="input-group">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-info-circle"></i></div>
                        <input type="text" name="last_name" class="form-control" id="registration_last_name" placeholder="Last name">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <select id="registration_podcast_id" class="form-control" name="podcast_id">
                        <option value="">Please choose podcast</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 1rem">
            <div class="col">
                <button class="btn btn-info js_register"><i class="fa fa-user-plus"></i> Register</button>
            </div>
        </div>
    </form>
</div>

<div class="container view" id="view_login">
    <h2>Please Login</h2>
    <form class="form-horizontal" role="form" method="POST" action="">
        <div class="row">
            <div class="col">
                <div class="form-group has-danger">
                    <div class="input-group">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                        <input type="text" name="email" class="form-control" id="login_email" placeholder="Your email" required autofocus>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group has-danger">
                    <div class="input-group">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                        <input type="password" name="password" class="form-control" id="login_password" placeholder="Your password" required autofocus>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 1rem">
            <div class="col">
                <button class="btn btn-success js_login"><i class="fa fa-sign-in"></i> Login</button>
                <button class="btn btn-info js_register"><i class="fa fa-user-plus"></i> Register</button>
            </div>
        </div>
    </form>
</div>

<!-- Bootstrap core JavaScript -->
<script src="/check/vendor/jquery/jquery.min.js"></script>
<script src="/check/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="/check/vendor/jquery-easing/jquery.easing.min.js"></script>

<script>

    var routes = {
        auth_login: '{{ route('auth_login') }}',
        auth_registration: '{{ route('auth_registration') }}',
        auth_getAuthenticatedUser: '{{ route('auth_getAuthenticatedUser') }}',
        podcast_index: '{{ action('Api\PodcastController@index') }}',
    }

</script>
@routes()
<!-- Custom scripts for this template -->
<script src="/check/js/resume.js?_=<?php echo time(); ?>"></script>

</body>

</html>
