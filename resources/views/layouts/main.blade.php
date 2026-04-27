@php
    $user           = \Auth::user();
    $primaryColor   = $user->theme_color;
    if (isset($primaryColor) && $primaryColor != '') {
        $color      = $primaryColor;
    } else {
        $color      = 'theme-2';
    }

    $currantLang = $user->currentLanguage();

@endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ $user->rtl_layout == 1 || $currantLang == 'ar' ? 'rtl' : '' }}">
<head>
    <title>@hasSection('title')@yield('title') | @endif{{ setting('app_name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-FW8W9F0T9Z"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-FW8W9F0T9Z');
</script>



@if ($user->rtl_layout == 1 || $currantLang == 'ar')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @endif
    @if ($user->dark_layout == 1)
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style-link">
    @elseif ($user->rtl_layout == 0)
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif


    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/custom.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    @stack('style')
</head>
<body class="{{ $color }}">
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
@include('layouts.sidebar')
@include('layouts.header')
</body>
<div class="dash-container">
    <div class="dash-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    @yield('breadcrumb')
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</div>
<footer class="dash-footer">
    <div class="footer-wrapper">
        <span class="text-muted">
            &copy; {{ date('Y') }} {{ setting('app_name') }}
        </span>
        <div class="py-1">
            <ul class="m-0 list-inline">
                <li class="list-inline-item">
                    <a class="link-secondary" href="javascript:"></a>
                </li>
                <li class="list-inline-item">
                    <a class="link-secondary" href="javascript:"> </a>
                </li>
                <li class="list-inline-item">
                    <a class="link-secondary" href="javascript:"></a>
                </li>
                <li class="list-inline-item">
                    <a class="link-secondary" href="javascript:"></a>
                </li>
            </ul>
        </div>
    </div>
</footer>
<div class="modal modal-animate anim-blur fade" role="dialog" id="common_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="body">
            </div>
        </div>
    </div>
</div>
<div class="modal modal-animate anim-blur fade" role="dialog" id="common_modal1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-animate anim-blur fade" role="dialog" id="common_modal2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
        </div>
    </div>
</div>
<div class="top-0 p-3 position-fixed end-0" style="z-index: 99999">
    <div id="liveToast" class="toast fade" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"> </div>
            <button type="button" class="m-auto btn-close btn-close-white me-2" data-bs-dismiss="toast"
                    aria-label="Close"></button>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>
<script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bouncer.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-validation.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
@if (!empty(setting('gtag')))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('gtag') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ setting('gtag') }}');
    </script>
@endif
<script>
    feather.replace();
    var pctoggle = document.querySelector("#pct-toggler");
    if (pctoggle) {
        pctoggle.addEventListener("click", function() {
            if (
                !document.querySelector(".pct-customizer").classList.contains("active")
            ) {
                document.querySelector(".pct-customizer").classList.add("active");
            } else {
                document.querySelector(".pct-customizer").classList.remove("active");
            }
        });
    }
    var themescolors = document.querySelectorAll(".themes-color > a");
    for (var h = 0; h < themescolors.length; h++) {
        var c = themescolors[h];
        c.addEventListener("click", function(event) {
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            var temp = targetElement.getAttribute("data-value");
            removeClassByPrefix(document.querySelector("body"), "theme-");
            document.querySelector("body").classList.add(temp);
        });
    }

    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
    $(document).ready(function() {
        $('.add_dark_mode').on('click', function() {
            var $this = $(this);
            $.ajax({
                url: "{{ route('change.theme.mode') }}",
                method: "POST",
                data: {
                    _token: $("meta[name='csrf-token']").attr('content'),
                },
                success: function(response) {
                    if (response.mode == 1) {
                        $this.find('i').removeClass('ti-sun').addClass('ti-moon');
                        $(".m-header > .b-brand > img").attr(
                            "src",
                            "{{ Storage::url(setting('app_logo')) ? Storage::url('app-logo/app-logo.png') : Storage::url('not-exists-data-images/78x78.png') }}"
                        );
                        document.querySelector("#main-style-link").setAttribute("href",
                            "{{ asset('assets/css/style-dark.css') }}"
                        );
                    } else {
                        $this.find('i').removeClass('ti-moon').addClass('ti-sun');
                        document.querySelector(".m-header > .b-brand > img").setAttribute(
                            "src",
                            "{{ Storage::url(setting('app_dark_logo')) ? Storage::url('app-logo/app-dark-logo.png') : Storage::url('not-exists-data-images/78x78.png') }}"
                        );
                        $(".m-header > .b-brand > img").attr(
                            "src",
                            response.app_dark_logo_url
                        );
                        document.querySelector("#main-style-link").setAttribute("href",
                            "{{ asset('assets/css/style.css') }}"
                        );
                    }
                }
            });
        });
    });
</script>
@include('layouts.includes.alerts')
@stack('script')
@if (Utility::getsettings('cookie_setting_enable') == 'on')
@include('layouts.cookie-consent')
@endif
</body>
</html>
