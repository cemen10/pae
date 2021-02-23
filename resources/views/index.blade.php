<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->

<head>

  <!--begin::Base Path (base relative path for assets of this page) -->
  {{-- <base href="../../../../"> --}}

  <!--end::Base Path -->
  <meta charset="utf-8" />
  <title>Iniciar Sesion</title>
  <meta name="description" content="Login page example">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!--begin::Fonts -->
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
  <script>
    WebFont.load({
                google: {
                    "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
                },
                active: function () {
                    sessionStorage.fonts = true;
                }
            });
  </script>
  <!--end::Fonts -->
  <!--begin::Page Custom Styles(used by this page) -->
  <link href="{{ asset('assets/css/demo1/pages/general/login/login-3.css') }}" rel="stylesheet" type="text/css" />
  @include('plantilla.head')
  <style>
    .fade-enter-active,
    .fade-leave-active {
      transition: opacity .5s;
    }

    .fade-enter,
    .fade-leave-to

    /* .fade-leave-active below version 2.1.8 */
      {
      opacity: 0;
    }

    /* .fade-transition{
                transition:  all 1s ease;
                opacity: 100;
            }
            .fade-enter, .fade-leave{
                opacity: 0;
            } */
  </style>
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body
  class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
  <!-- begin:: Page -->

  <div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
      <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor"
        style="background-image: url({{asset('assets/media//bg/bg-3.jpg')}});">
        <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
          <div class="kt-login__container">
            <div class="kt-login__logo">
              <a href="#">
                <img src="{{asset('assets/media/logos/logo-5.png')}}">
              </a>
            </div>
            <div class="row justify-content-center">
              <div class="col-md-12">
                @if(Session::has('error'))
                <div class="row">
                  <div class="col-md-12">
                    <div class="kt-alert kt-alert--outline alert alert-danger alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                      <strong>{!!session('error') !!}</strong>
                    </div>
                  </div>
                </div>
                @endif
                @if(Session::has('success'))
                <div class="row">
                  <div class="col-md-12">
                    <div class="kt-alert kt-alert--outline alert alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                      <strong>{!! session('success')!!}</strong>
                    </div>
                  </div>
                </div>
                @endif
              </div>
            </div>
            <div class="kt-login__signin">
              <div class="kt-login__head">
                <h3 class="kt-login__title">Iniciar Sesión</h3>
              </div>
              <form class="kt-form" action="{{ url('/login') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                  <input class="form-control" type="text" placeholder="Usuario ó Email" name="email" autocomplete="off">
                </div>
                <div class="form-group">
                  <input class="form-control form-control-last" type="Password" name="password"
                    placeholder="Contraseña">
                </div>
                <div class="row kt-login__extra">
                  <div class="col kt-align-left">

                  </div>
                  <div class="col kt-align-right">
                    <a href="javascript:;" id="kt_login_forgot" class="kt-link">¿Ovido su
                      contraseña?</a>
                  </div>
                </div>
                <div class="kt-login__actions">
                  <button class="btn btn-brand btn-pill btn-elevate" type="submit">
                    Entrar
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="kt-login__divider">
          <div></div>
        </div>
      </div>
    </div>
  </div>
  @include('plantilla.footer')
  
  <!-- end:: Page -->
</body>

<!-- end::Body -->

</html>