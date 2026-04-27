<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>@hasSection('title')@yield('title') | @endif{{ setting('app_name') }}</title>
    <meta name="title"
          content="{{ !empty(Utility::getsettings('meta_title'))
        ? Utility::getsettings('meta_title') :  Utility::getsettings('app_name')  }}">
    <meta name="keywords"
          content="{{ !empty(Utility::getsettings('meta_keywords'))
        ? Utility::getsettings('meta_keywords')
        : 'Multi Users,Role & permission , Form & poll management , document Genrator , Booking system' }}">
    <meta name="description"
          content="{{ !empty(Utility::getsettings('meta_description'))
        ? Utility::getsettings('meta_description')
        : 'Discover the efficiency of prime laravel Saas, a user-friendly web application by Quebix Apps.' }}">
    <meta name="meta_image_logo" property="og:image"
          content="{{ !empty(Utility::getsettings('meta_image_logo'))
        ? Storage::url(Utility::getsettings('meta_image_logo'))
        : Storage::url('seeder-image/meta-image-logo.jpg') }}">
    @if (Utility::getsettings('seo_setting') == 'on')
        {!! app('seotools')->generate() !!}
    @endif
    <link rel="icon"
          href="{{ setting('favicon_logo') ? Storage::url('app-logo/app-favicon-logo.png') : asset('assets/images/app-favicon-logo.png') }}"
          type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">



    <link rel="stylesheet" href="{{ asset('vendor/landing-page2/css/landingpage-2.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/landing-page2/css/landingpage2-responsive.css') }}">
    @stack('style')

    {{--  ----------------------------  --}}

<!-- Favicons -->
    <link href="{{ asset('vendor/img/favicon.png') }}" rel="icon">
    <link href="{{ url('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="{{ url('https://fonts.googleapis.com') }}">
    <link rel="preconnect" href="{{ url('https://fonts.gstatic.com') }}" crossorigin>
    <link
        href="{{ url('https://fonts.googleapis.com/css2?family=Jost:wght@200&display=swap') }}"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" rel="stylesheet">


    <link href="{{ asset('assets/css/stone.css?v=5') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/stone1.css') }}" rel="stylesheet">




<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-FW8W9F0T9Z"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-FW8W9F0T9Z');
</script>



    {{--  --------------------------------------------  --}}

</head>

<body class="light">
<!--header start here-->
@include('layouts.front-header')
<!--header end here-->
{{-- <main class="home-wrapper"> --}}
@yield('content')
{{-- </main> --}}
<!--footer start here-->
@include('layouts.front-footer')
<!--footer end here-->
<!--scripts start here-->
<script src="{{ asset('vendor/landing-page2/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/landing-page2/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bouncer.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-validation.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('vendor/landing-page2/js/custom.js') }}"></script>

{{--  --------------------------------  --}}
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/js/glightbox.min.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<!-- php-email-form validate.js removed: server-side validation used -->

<!-- Template Main JS File -->
<script>
// AOS initialization (replaces missing main.js)
document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') { AOS.init({ duration: 1000, easing: 'ease-in-out', once: true, mirror: false }); }
});
</script>

{{--  --------------------------------  --}}



<!--scripts end here-->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const playButton = document.getElementById('playButton');
        const videoPlayer = document.getElementById('videoPlayer');
        if (playButton) {
            playButton.addEventListener('click', () => {
                videoPlayer.style.display = 'block';
                videoPlayer.play();
                playButton.style.display = 'none';
            });
        }
    });

    function myFunction() {
        const element = document.body;
        element.classList.toggle("dark-mode");

        const isDarkMode = element.classList.contains("dark-mode");
        const expirationDate = new Date();
        expirationDate.setDate(expirationDate.getDate() + 30);
        document.cookie = `mode=${isDarkMode ? "dark" : "light"}; expires=${expirationDate.toUTCString()}; path=/`;
        if (isDarkMode) {
            $('.switch-toggle').find('.switch-moon').addClass('d-none');
            $('.switch-toggle').find('.switch-sun').removeClass('d-none');
        } else {
            $('.switch-toggle').find('.switch-sun').addClass('d-none');
            $('.switch-toggle').find('.switch-moon').removeClass('d-none');
        }
    }






    window.addEventListener("DOMContentLoaded", () => {
        const modeCookie = document.cookie.split(";").find(cookie => cookie.includes("mode="));
        if (modeCookie) {
            const mode = modeCookie.split("=")[1];
            if (mode === "dark") {
                $('.switch-toggle').find('.switch-moon').addClass('d-none');
                $('.switch-toggle').find('.switch-sun').removeClass('d-none');
                document.body.classList.add("dark-mode");
            } else {
                $('.switch-toggle').find('.switch-sun').addClass('d-none');
                $('.switch-toggle').find('.switch-moon').removeClass('d-none');
            }
        }
    });
    @if (session('failed'))
    showToStr('Failed!', '{{ session('failed') }}', 'danger');
    @endif
    @if ($errors = session('errors'))
    @if (is_object($errors))
    @foreach ($errors->all() as $error)
    showToStr('Error!', '{{ $error }}', 'danger');
    @endforeach
    @else
    showToStr('Error!', '{{ session('errors') }}', 'danger');
    @endif
    @endif
    @if (session('successful'))
    showToStr('Successfully!', '{{ session('successful') }}', 'success');
    @endif
    @if (session('success'))
    showToStr('Done!', '{{ session('success') }}', 'success');
    @endif
    @if (session('warning'))
    showToStr('Warning!', '{{ session('warning') }}', 'warning');
    @endif
    @if (session('status'))
    showToStr('Great!', '{{ session('status') }}', 'info');
    @endif
</script>
<script>
    var headerHright = $('header').outerHeight();
    $('header').next('.home-banner-sec').css('padding-top', headerHright + 'px');
</script>
@stack('script')
</body>
@if (Utility::keysettings('cookie_setting_enable', 1) == 'on')
    @include('layouts.cookie-consent')
@endif

</html>
