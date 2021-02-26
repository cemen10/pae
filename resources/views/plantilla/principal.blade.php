<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->

<head>
  <!--begin::Base Path (base relative path for assets of this page) -->
  {{-- <base href="../"> --}}

  <!--end::Base Path -->
  <meta charset="utf-8" />
  <title>Pae | @yield('title','Cesar Norte')</title>
  <meta name="description" content="Updates and statistics">
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
  @include('plantilla.head')
</head>
<!-- end::Head -->
<!-- begin::Body -->

<body
  class="
    kt-quick-panel--right 
    kt-demo-panel--right 
    kt-offcanvas-panel--right 
    kt-header--fixed 
    kt-header-mobile--fixed 
    kt-subheader--fixed 
    kt-subheader--enabled 
    kt-subheader--solid 
    kt-aside--enabled 
    kt-aside--fixed 
    kt-page--loading 
    kt-aside--minimize 
    kt-footer--fixed">
  <div id="app">
    <!-- begin:: Page -->
    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
      <div class="kt-header-mobile__logo">
        <a href="{{ url('/administracion') }}">
          <img src="{{asset('assets/Imagenes/logo2.png')}}" style="width: 70%;">
        </a>
      </div>
      <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left"
          id="kt_aside_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
            class="flaticon-more"></i></button>
      </div>
    </div>
    <!-- end:: Header Mobile -->
    <div class="kt-grid kt-grid--hor kt-grid--root">
      <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

        <!-- begin:: Aside -->
        <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
        @include('plantilla.menu')

        <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
          <!-- begin:: Header -->
          @include('plantilla.barra')
          <!-- end:: Header -->
          <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
            <!-- begin:: Content -->
            <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
              @yield('contenido')
            </div>
            <!-- end:: Content -->
          </div>

          <!-- begin:: Footer -->
          <div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
            <div class="kt-footer__copyright">
              Copyright &copy;<script>
                document.write(new Date().getFullYear());
              </script> <a href="#"> &nbsp;CMMPSOFT&nbsp;</a> Todos los derechos reservados.
            </div>
          </div>

          <!-- end:: Footer -->
        </div>
      </div>
    </div>

    <!-- end:: Page -->

    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
      <i class="fa fa-arrow-up"></i>
    </div>

    <!-- end::Scrolltop -->

  </div>

  @include('plantilla.footer')
  @yield('scripts')
</body>
<!-- end::Body -->

</html>