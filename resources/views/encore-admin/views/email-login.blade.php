<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('admin.title')}} | {{ admin_trans('admin.login') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <meta name="description" content="Login into the ogua school management system. (Ogua Software)">
<meta name="keywords" content="Ogua schoolz, oguaschoolz, Oguses IT Solutions, OguSesITSolutions, Ogua, oguses, sesali kaisu, ogua ahmed, ogua, ogua lamere, ogua lamar, ogua software, ogua crm, School management System, Website Design, Mobile phone, web development, software, contactus, Ogua crm, ogua, basic school management system, college school management system, all school management system, IT solutions, Oguses, ogusesitsolutions, ogusesit, oguses solutions, website, records management system, records system, sms alert, sms schedule, sms messages, registry system, registry, mobile applications, SEO, Auditing, stock management system, stock systems, church, church website, church systems, church management system, School system in Ghana, Ghana latest software, Ghana software companies, college management system in Ghana, Ghana software companies, Ghana school software company">
<link rel="canonical" href="http://oguaschool.com/admin/auth/login">

  <meta property="og:description" content="Login into the ogua school management system. (Ogua Software)">
<meta property="og:title" content="{{config('admin.title')}} | {{ admin_trans('admin.login') }}">
<meta property="og:type" content="website">
<meta property="og:url" content="http://oguaschool.com/admin/auth/login">
<meta property="og:image" content="http://oguaschool.com/images/images.png">


  <meta name="twitter:title" content="{{config('admin.title')}} | {{ admin_trans('admin.login') }}">
<meta name="twitter:site" content="@blogogua">
<meta name="twitter:image" content="http://oguaschool.com/images/images.png">
<meta name="twitter:description" content="Login into the ogua school management system. (Ogua Software)">

  <script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"{{config('admin.title')}} | {{ admin_trans('admin.login') }}","description":"Login into the ogua school management system. (Ogua Software)"}</script>

    <link rel="shortcut icon" href="{{ URL::to('images/favicon.ico') }}">

    <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/fontawesome-free/css/all.min.css") }}">
    <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/icheck-bootstrap/icheck-bootstrap.min.css") }}">
    <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/css/adminlte.min.css") }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
    <script src="{{ admin_asset("vendor/laravel-admin/jquery/jquery.min.js") }}"></script>
</head>
<body class="text-sm row vh-100 overflow-hidden">

     @if((new \Jenssegers\Agent\Agent())->isMobile())

     <div class="col-2" {!! admin_login_page_backgroud() !!}></div>

    <div class="col-10 d-flex justify-content-center align-items-center bg-light">

     @else

     <div class="col-5" {!! admin_login_page_backgroud() !!}></div>

    <div class="col-7 d-flex justify-content-center align-items-center bg-light">

     @endif
    
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ admin_url('/') }}"><b>
                Login By Email
            </b></a>
            </div>

            <div class="card">
                <div class="card-body login-card-body">
                    @include('notify_status.notify')
                    
                    <form action="{{ route('login-email') }}" method="post">
                        <div class="form-group">
                            @if($errors->has('username'))
                                @foreach($errors->get('username') as $message)
                                    <label class="col-form-label text-danger">
                                        <i class="fa fa-times-circle-o"></i>{{$message}}
                                    </label><br>
                                @endforeach
                            @endif
                            <div class="input-group mb-3">
                                <input type="text" class="form-control " placeholder="{{ admin_trans('formfields.email') }}"
                                       name="username" value="{{ old('username') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @if($errors->has('password'))
                                @foreach($errors->get('password') as $message)
                                    <label class="col-form-label text-danger">
                                        <i class="fa fa-times-circle-o"></i>{{$message}}
                                    </label>
                                    <br>
                                @endforeach
                            @endif
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="{{ admin_trans('Formfields.phone') }}"
                                       name="password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="icheck-@color">
                                    <input type="checkbox" id="remember" name="remember"
                                           value="1" {{ (!old('username') || old('remember')) ? 'checked' : '' }}>
                                    <label for="remember">
                                        {{ admin_trans('admin.remember_me') }}
                                    </label>
                                </div>
                            </div>

                            <!-- /.col -->
                            <div class="col-md-4">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-@color btn-block">
                                    {{ admin_trans('admin.login') }}
                                </button>
                            </div>
                            <!-- /.col -->
                        </div>

                        <div class="col-12">
                            <a href="/admin/auth/login">Main Login</a>
                        </div>
                        
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </div>
    <script type="text/javascript">
        $(function () {
            $('form input[name=username]').focus();
        });
    </script>
</body>
</html>
