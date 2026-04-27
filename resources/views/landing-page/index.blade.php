

@extends('layouts.main-landing')
@section('content')


    <!-- ======= Header ======= -->
    {{--  <header id="header" id="s-navbar" class="fixed-top">
      <div class="container d-flex align-items-center justify-content-between">

        <!-- <h1 class="logo"><a href="assets/img/stone/logo.png"></a></h1> -->
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="index.html" class="logo"><img class="logo-img"
            src="{{ asset('assets/img/stone/logo.png') }}"
            alt></a>

        <nav id="navbar" class="navbar">
          <ul>
            <li><a class="nav-link scrollto active"
                href="#hero">English</a></li>
            <li><a class="nav-link scrollto" href="#about">Try Demo</a></li>
            <li><a class="nav-link scrollto" href="#services">Pricing</a></li>
            <li><a class="nav-link nav-nargin-setting scrollto "
                href="#portfolio">Templates</a></li>

            <li><a class="getstarted scrollto" href="#about">Signup</a></li>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

      </div>
    </header><!-- End Header -->  --}}
    <section id="hero" class="d-flex working-one align-items-center">
        <div class="container d-flex flex-column mt-4 align-items-center justify-content-center" data-aos="fade-up" id="hero-heading">
        <span class="hero-heading-size">
            Unlock Your <span class="red-color">Business </span>
            <span class="blue-color">Potential with</span>
            Onestone Form Builder <span class="blue-color"> Tool  -</span>
            Capture Valuable  <span class="red-color">Customer Data Effortlessly</span>
        </span>
            <p class="hero-para">
                Experience Onestone Form Builder for effortless data collection and enhanced customer engagement.
                With WhatsApp integration, design flexibility, and AI-powered capabilities, streamline your process and share forms easily via email.
            </p>

            @if (!Auth::user())
            <a href="/redirect/google" class="btn-get-started" id="google_btn">
                <img class="google-icon" src="{{ asset('assets/img/stone/google.svg') }}" alt>
                <span class="signupGoogle">Signup With Google</span>
            </a>
            @endif
        </div>
{{--        <div class="heroimg">--}}
{{--            <img src="" class="img-dashboard"  alt="">--}}

{{--        </div>--}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/img/stone/hero.png') }}" class="img-fluid" alt="Centered Image">
                </div>
            </div>
        </div>
    </section><!-- End Hero -->


    <main id="main">

        <!-- ======= Features Section ======= -->
        <section id="features" class="features" data-aos="fade-up">
            <div class="container-fluid" id="container-width">

                <div class="row content flex-div">
                    <div class="col-md-5 righ-image" data-aos="fade-right"
                         data-aos-delay="100">
                        <img src="{{ asset('assets/img/stone/right.png') }}" class="img-fluid" alt>
                    </div>
                    <div class="col-md-7 pt-4" data-aos="fade-left"
                         data-aos-delay="100">
                        <h5 class="red-color working align-text">Working</h5>
                        <h3 class="align-text">How Our <span
                                class="red-color align-text">Form Builder</span> works</h3>
                        <p class="align-text">
                            Experience the streamlined efficiency of Onestone Form Builder,
                            where simplicity meets effectiveness. Our platform simplifies tasks like capturing customer feedback,
                            facilitating registration forms, and conducting customer surveys in one unified space. Unique features include:

                        </p>
                        <ul class="numbered-list-mobile">
                            <li class="workin-list align-text">
                                <span class="box">01</span>
                                <p>
                                    Drag-and-drop Form Fields for Ease of use.
                                </p>
                            </li>
                            <li class="workin-list align-text">
                                <span class="box">02</span>
                                <p>WhatsApp integration for customer connection.</p>
                            </li>
                            <li class="workin-list align-text"><span class="box">03</span>
                                <p>Share filled forms in PDF via Email or WhatsApp.
                                </p>
                            </li><li class="workin-list align-text"><span class="box">04</span>
                                <p>AI-Powered capabilities for creating forms effortlessly from text or uploading images.
                                </p></li>
                        </ul>

                        <ul class="numbered-list-desktop">

                            <li class="workin-list align-text"><span class="box">01</span>
                                Drag-and-drop Form Fields for Ease of use.</li>
                            <li class="workin-list align-text"><span class="box">02</span>
                                WhatsApp integration for customer connection.</li>
                            <li class="workin-list align-text "><span class="box">03</span>
                                Share filled forms in PDF via Email or WhatsApp.</li>
                            <li class="workin-list align-text"><span class="box">04</span>
                                AI-Powered capabilities for creating forms effortlessly from text or uploading images.</li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>

                <div class="row content flex-div">
                    <div class="col-md-5 righ-image-mobile" >
                        <img src="{{ asset('assets/img/stone/mobile.png') }}" class="img-fluid" alt>
                    </div>
                    <div class="col-md-5 righ-image-desktop" data-aos="fade-right">
                        <img src="{{ asset('assets/img/stone/right2.png') }}" class="img-fluid" alt>
                    </div>

                    <div class="col-md-7 pt-5" data-aos="fade-left">
                        <h3 class="working-4 align-text">Say <span class="red-color">Goodbye
                  to</span> Spreadsheets and Signup <span
                                class="blue-color">with Google</span> </h3>
                        <p class="align-text">With Onestone Form Builder, you can harness the power of cutting-edge features to streamline your feedback collection process and enhance customer engagement.
                            Experience the ease and efficiency of Onestone Form Builder Tool and revolutionize your feedback collection process today.</p>
                        <br>
                        <div>

                            <video class="video-container" width="320" controls>
{{--                                <source src="{{ asset('assets/img/stone/Onestoneadsform.mp4') }}" type="video/mp4">--}}
                                <source src="{{url('/public/assets/img/stone/Onestoneadsform.mp4')}}" type="video/ogg">.

                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>

            <!-- <div class="row content">
            <div class="col-md-5 order-1 order-md-2" data-aos="fade-left">
              <img src="{{ asset('assets/img/features-4.png') }}" class="img-fluid" alt>
            </div>
            <div class="col-md-7 pt-5 order-2 order-md-1" data-aos="fade-right">
              <h3>Quas et necessitatibus eaque impedit ipsum animi consequatur
                incidunt in</h3>
              <p class="fst-italic">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore
                magna aliqua.
              </p>
              <p>
                Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
                aute irure dolor in reprehenderit in voluptate
                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                sint occaecat cupidatat non proident, sunt in
                culpa qui officia deserunt mollit anim id est laborum
              </p>
            </div>
          </div> -->

            </div>
        </section><!-- End Features Section -->

        <div class="container">
            <br><br><br>

            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <h1 class="main-title">
                        <span class="title-part" style="color: #1D1D1D;">Choose </span>
                        <span class="title-part" style="color: #24C6E3;">from our</span>
                        <span class="title-part" style="color: #1D1D1D;"> ready to </span>
                        <span class="title-part" style="color: #EC367E;">use templates</span>
                    </h1>
                </div>
                <div class="col-12 text-center">
                    <p class="secondary-text">
                        Explore efficiency with Form's Builder ready-to-use templates. From orders to registrations, bookings, surveys, and feedback – our pre-designed solutions simplify your workflow. Choose a template, sign up effortlessly with Google, and experience seamless task management.
                    </p>
                </div>
            </div>
        </div>
        <div class="container">
            <br><br><br>
            <div class="row">
                <div class="col-md-4">
                    <div class="card custom-card">
                        <img src="{{asset('assets/img/picture1.png')}}" class="card-img-top custom-img" alt="Card Image">
                        <div class="card-body">
                            <h5 class="card-title custom-title">Travel Booking</h5>
                            <p class="card-text custom-content">Use this simple form to get travel requirements from your customer Create Travel Form</p>
                            <a href="{{ route('home') }}" class="btn btn-primary custom-btn">Create Travel Form</a>
                            <br>
                        </div>
                    </div>
                </div>
                <!-- Repeat the above card structure for the other two cards -->
                <div class="col-md-4">
                    <div class="card custom-card">
                        <img src="{{asset('assets/img/picture2.png')}}" class="card-img-top custom-img" alt="Card Image">
                        <div class="card-body">
                            <h5 class="card-title custom-title">Contact Form</h5>
                            <p class="card-text custom-content">Get general inquires from anyone using this classic contact form Create Contact Form</p>
                            <a href="{{ route('home') }}" class="btn btn-primary custom-btn">Create Contact Form</a>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card custom-card">
                        <img src="{{asset('assets/img/picture3.png')}}" class="card-img-top custom-img" alt="Card Image">
                        <div class="card-body">
                            <h5 class="card-title custom-title">Customer Feedback</h5>
                            <p class="card-text custom-content">Collect feedbacks from your customers about their experience Create Feedback Form</p>
                            <a href="{{ route('home') }}" class="btn btn-primary custom-btn">Create Feedback Form</a>
                            <br>
                        </div>
                    </div>
                </div>
                <br><br><br>
            </div>
        </div>

        <br><br><br><br>
        <section class="testimonials-sec" id="testimonials">
            <div class="container">
                <div class="section-title">
                    <h2> {{ Utility::keysettings('testimonial_name', 1)  }}
                        <b> {{ Utility::keysettings('testimonial_bold_name', 1) ? Utility::keysettings('testimonial_bold_name', 1) : __('Our customer say') }}
                        </b>
                    </h2>
{{--                    <p>--}}
{{--                        {{ Utility::keysettings('testimonial_detail', 1)--}}
{{--                            ? Utility::keysettings('testimonial_detail', 1)--}}
{{--                            : __(--}}
{{--                                'Its similar to case studies, but this format allows the company to tell the customers story from their own perspective.',--}}
{{--                            ) }}--}}
{{--                    </p>--}}
                </div>



                <div class="testimonial-slider">
                    @if (isset($testimonials))
                        @foreach ($testimonials as $testimonial)
                            <div class="testimonial-card">
                                <div class="testimonial-card-inner">
                                    <div class="testimonial-card-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="37"
                                             viewBox="0 0 42 37" fill="none">
                                            <path
                                                d="M2.10973 -2.722e-06L14.9411 -4.78488e-07C16.1061 -2.74801e-07 17.0515 0.945469 17.0515 2.11042L17.0515 14.9418C17.0515 16.1068 16.1061 17.0522 14.9411 17.0522L8.79977 17.0522C8.87997 20.412 9.66082 23.1007 11.1381 25.1225C12.3031 26.7179 14.0673 28.0391 16.4268 29.0816C17.5116 29.5586 17.9801 30.8417 17.4736 31.9139L15.9541 35.1217C15.4645 36.1515 14.2531 36.6032 13.2063 36.1515C10.4121 34.9444 8.05264 33.4164 6.12797 31.5593C3.78114 29.2927 2.17304 26.7348 1.30355 23.8815C0.434012 21.0282 -0.000693456 17.1366 -0.000692593 12.1982L-0.000690829 2.11042C-0.000690626 0.945508 0.944822 -2.92568e-06 2.10973 -2.722e-06Z"
                                                fill="black" />
                                            <path
                                                d="M36.6786 36.1431C33.9182 34.9402 31.5714 33.4123 29.634 31.5593C27.2661 29.2927 25.6496 26.7433 24.7801 23.9111C23.9106 21.0789 23.4759 17.1746 23.4759 12.1982L23.4759 2.11042C23.4759 0.945466 24.4213 -2.92569e-06 25.5863 -2.722e-06L38.4177 -4.78488e-07C39.5826 -2.74801e-07 40.5281 0.945469 40.5281 2.11042L40.5281 14.9418C40.5281 16.1068 39.5826 17.0522 38.4177 17.0522L32.2763 17.0522C32.3565 20.4121 33.1374 23.1007 34.6147 25.1225C35.7796 26.7179 37.5439 28.0391 39.9034 29.0816C40.9882 29.5586 41.4567 30.8417 40.9502 31.9139L39.4349 35.1133C38.9452 36.1431 37.7254 36.599 36.6786 36.1431Z"
                                                fill="black" />
                                        </svg>
                                        <p>{{ $testimonial->desc }}</p>
                                        <div class="client-info">
                                            <div class="client-img">
                                                <img src="{{ Storage::url($testimonial->image) }}" alt="client-image"
                                                     width="100%" height="100%">
                                            </div>
                                            <div class="client-name">
                                                <a href="javascript:void(0);" style="color: red; text-transform: capitalize">{{ $testimonial->name }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <img src="{{ asset('vendor/landing-page2/image/test-bg.png') }}" alt="testimonial-bg"
                     class="testimonial-bg">
                <img src="{{ asset('vendor/landing-page2/image/test-bg-2.png') }}" alt="testimonial-bg"
                     class="testimonial-bg-2">
                <img src="{{ asset('vendor/landing-page2/image/test-bg-3.png') }}" alt="testimonial-bg"
                     class="testimonial-bg-3">
            </div>
        </section>
{{--        <!-- ======= Testimonials Section ======= -->--}}
{{--        <section id="testimonials" class="testimonials section-bg">--}}
{{--            <div class="container" data-aos="fade-up">--}}

{{--                <div class="section-title">--}}
{{--                    <h2>In Our <span class="red-color">Client’s</span> <span--}}
{{--                            class="blue-color">Words</span></h2>--}}
{{--                    <div class="client-para">--}}
{{--                        <p>Our clients speak volumes about Form Builder – a seamless--}}
{{--                            experience, simplified tasks, and unparalleled efficiency.--}}
{{--                            Discover their words and experience the impact firsthand.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="testimonials-slider swiper" data-aos="fade-up"--}}
{{--                     data-aos-delay="100">--}}
{{--                    <div class="swiper-wrapper">--}}

{{--                        <div class="swiper-slide">--}}
{{--                            <div class="testimonial-item">--}}
{{--                                <p class="">--}}
{{--                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>--}}
{{--                                    Lorem Ipsum is simply dummy text of the printing and--}}
{{--                                    typesetting industry. Lorem Ipsum has been the industry's--}}
{{--                                    standard dummy text ever since the 1500s, when an unknown--}}
{{--                                    printer took a galley of type and scrambled it to make a--}}
{{--                                    type specimen book.--}}
{{--                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>--}}
{{--                                </p>--}}

{{--                                <div class="star-rating">--}}
{{--                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                </div>--}}

{{--                                <div class="float">--}}
{{--                                    <img src="{{ asset('assets/img/testimonials/testimonials-4.jpg') }}"--}}
{{--                                         class="testimonial-img" alt>--}}

{{--                                </div>--}}

{{--                            </div>--}}
{{--                            <div class="client-data">--}}
{{--                                <h3 class="client-name">Kevin Heart</h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- End testimonial item -->--}}

{{--                        <div class="swiper-slide">--}}
{{--                            <div class="testimonial-item">--}}
{{--                                <p>--}}
{{--                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>--}}
{{--                                    Lorem Ipsum is simply dummy text of the printing and--}}
{{--                                    typesetting industry. Lorem Ipsum has been the industry's--}}
{{--                                    standard dummy text ever since the 1500s, when an unknown--}}
{{--                                    printer took a galley of type and scrambled it to make a--}}
{{--                                    type specimen book.--}}
{{--                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>--}}
{{--                                </p>--}}

{{--                                <div class="star-rating">--}}
{{--                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                </div>--}}

{{--                                <div class="float">--}}
{{--                                    <img src="{{ asset('assets/img/testimonials/testimonials-2.jpg') }}"--}}
{{--                                         class="testimonial-img" alt>--}}

{{--                                </div>--}}

{{--                            </div>--}}
{{--                            <div class="client-data">--}}
{{--                                <h3 class="client-name">Sara Wilsson</h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- End testimonial item -->--}}

{{--                        <div class="swiper-slide">--}}
{{--                            <div class="testimonial-item">--}}
{{--                                <p>--}}
{{--                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>--}}
{{--                                    Lorem Ipsum is simply dummy text of the printing and--}}
{{--                                    typesetting industry. Lorem Ipsum has been the industry's--}}
{{--                                    standard dummy text ever since the 1500s, when an unknown--}}
{{--                                    printer took a galley of type and scrambled it to make a--}}
{{--                                    type specimen book.--}}
{{--                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>--}}
{{--                                </p>--}}

{{--                                <div class="star-rating">--}}
{{--                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                </div>--}}

{{--                                <div class="float">--}}
{{--                                    <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}"--}}
{{--                                         class="testimonial-img" alt>--}}

{{--                                </div>--}}

{{--                            </div>--}}
{{--                            <div class="client-data">--}}
{{--                                <h3 class="client-name">Shane David</h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- End testimonial item -->--}}

{{--                        <div class="swiper-slide">--}}
{{--                            <div class="testimonial-item">--}}
{{--                                <p>--}}
{{--                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>--}}
{{--                                    Lorem Ipsum is simply dummy text of the printing and--}}
{{--                                    typesetting industry. Lorem Ipsum has been the industry's--}}
{{--                                    standard dummy text ever since the 1500s, when an unknown--}}
{{--                                    printer took a galley of type and scrambled it to make a--}}
{{--                                    type specimen book.--}}
{{--                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>--}}
{{--                                </p>--}}

{{--                                <div class="star-rating">--}}
{{--                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                    <span class="star"><img src="{{ asset('assets/img/stone/Star.png') }}"--}}
{{--                                                            alt></span>--}}
{{--                                </div>--}}

{{--                                <div class="float">--}}
{{--                                    <img src="{{ asset('assets/img/testimonials/testimonials-3.jpg') }}"--}}
{{--                                         class="testimonial-img" alt>--}}

{{--                                </div>--}}

{{--                            </div>--}}
{{--                            <div class="client-data">--}}
{{--                                <h3 class="client-name">Julia Anderson</h3>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- End testimonial item -->--}}

{{--                    </div>--}}
{{--                    <!-- <div class="swiper-pagination"></div> -->--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </section><!-- End Testimonials Section -->--}}

{{--        <!-- ======= Template ======= -->--}}
{{--        <section id="team" class="team">--}}
{{--            <div class="container" data-aos="fade-up">--}}
{{--                <div class="section-title">--}}
{{--                    <h2>Choose <span class="blue-color">From Our</span> Ready to <span--}}
{{--                            class="red-color">Use Templates</span></h2>--}}
{{--                    <div class="template-para">--}}
{{--                        <p>Explore efficiency with Form's Builder ready-to-use templates.--}}
{{--                            From orders to registrations, bookings, surveys, and feedback –--}}
{{--                            our pre-designed solutions simplify your workflow. Choose a--}}
{{--                            template, sign up effortlessly with Google, and experience--}}
{{--                            seamless task management.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="row template-flex">--}}

{{--                    <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up"--}}
{{--                         data-aos-delay="100">--}}
{{--                        <div class="card member-div text-center">--}}
{{--                            <img class="member-image" src="{{ asset('assets/img/stone/template/1.png') }}"--}}
{{--                                 class="card-img-top" alt="Image">--}}
{{--                            <div class="card-body card-content">--}}
{{--                                <h5 class="card-name">Travel Booking</h5>--}}
{{--                                <h6 class="card-designation">Use this simple form to get--}}
{{--                                    travel requirements from your customer Create Travel--}}
{{--                                    Form</h6>--}}
{{--                                <button class="travel-button">Create Travel Form</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up"--}}
{{--                         data-aos-delay="100">--}}
{{--                        <div class="card member-div text-center">--}}
{{--                            <img class="member-image" src="{{ asset('assets/img/stone/template/2.png') }}"--}}
{{--                                 class="card-img-top" alt="Image">--}}
{{--                            <div class="card-body card-content">--}}
{{--                                <h5 class="card-name">Travel Booking</h5>--}}
{{--                                <h6 class="card-designation">Use this simple form to get--}}
{{--                                    travel requirements from your customer Create Travel--}}
{{--                                    Form</h6>--}}
{{--                                <button class="travel-button">Create Travel Form</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up"--}}
{{--                         data-aos-delay="100">--}}
{{--                        <div class="card member-div text-center">--}}
{{--                            <img class="member-image" src="{{ asset('assets/img/stone/template/3.png') }}"--}}
{{--                                 class="card-img-top" alt="Image">--}}
{{--                            <div class="card-body card-content">--}}
{{--                                <h5 class="card-name">Travel Booking</h5>--}}
{{--                                <h6 class="card-designation">Use this simple form to get--}}
{{--                                    travel requirements from your customer Create Travel--}}
{{--                                    Form</h6>--}}
{{--                                <button class="travel-button">Create Travel Form</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <!-- Repeat the same structure for other two col-xl-3 divs -->--}}
{{--                </div>--}}

{{--                <!-- second Row -->--}}

{{--                <div class="row template-flex">--}}

{{--                    <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up"--}}
{{--                         data-aos-delay="100">--}}
{{--                        <div class="card member-div text-center">--}}
{{--                            <img class="member-image" src="{{ asset('assets/img/stone/template/4.png') }}"--}}
{{--                                 class="card-img-top" alt="Image">--}}
{{--                            <div class="card-body card-content">--}}
{{--                                <h5 class="card-name">Travel Booking</h5>--}}
{{--                                <h6 class="card-designation">Use this simple form to get--}}
{{--                                    travel requirements from your customer Create Travel--}}
{{--                                    Form</h6>--}}
{{--                                <button class="travel-button">Create Travel Form</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up"--}}
{{--                         data-aos-delay="100">--}}
{{--                        <div class="card member-div text-center">--}}
{{--                            <img class="member-image" src="{{ asset('assets/img/stone/template/5.png') }}"--}}
{{--                                 class="card-img-top" alt="Image">--}}
{{--                            <div class="card-body card-content">--}}
{{--                                <h5 class="card-name">Travel Booking</h5>--}}
{{--                                <h6 class="card-designation">Use this simple form to get--}}
{{--                                    travel requirements from your customer Create Travel--}}
{{--                                    Form</h6>--}}
{{--                                <button class="travel-button">Create Travel Form</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up"--}}
{{--                         data-aos-delay="100">--}}
{{--                        <div class="card member-div text-center">--}}
{{--                            <img class="member-image" src="{{ asset('assets/img/stone/template/6.png') }}"--}}
{{--                                 class="card-img-top" alt="Image">--}}
{{--                            <div class="card-body card-content">--}}
{{--                                <h5 class="card-name">Travel Booking</h5>--}}
{{--                                <h6 class="card-designation">Use this simple form to get--}}
{{--                                    travel requirements from your customer Create Travel--}}
{{--                                    Form</h6>--}}
{{--                                <button class="travel-button">Create Travel Form</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <!-- Repeat the same structure for other two col-xl-3 divs -->--}}
{{--                </div>--}}

{{--            </div>--}}

{{--        </section><!-- End Team Section -->--}}


        {{--  Pricing Section  --}}

        @if (Utility::keysettings('plan_setting_enable', 1) == 'on')
            <section class="pricing-plans-sec pt pb" id="plans">
                <div class="container">
                    <div class="section-title">
                        <h2> {{ Utility::keysettings('plan_name', 1) ? Utility::keysettings('plan_name', 1) : __('Simple, Flexible') }}
                            <b style="color: red;"> {{ Utility::keysettings('plan_bold_name', 1) ? Utility::keysettings('plan_bold_name', 1) : __('Pricing') }}
                            </b>
                        </h2>
                        <p>
                            {{ Utility::keysettings('plan_detail', 1)
                                ? Utility::keysettings('plan_detail', 1)
                                : __('The pricing structure is easy to comprehend, and all costs and fees are explicitly stated. There
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    are no hidden charges or surprise costs for customers.') }}
                        </p>
                    </div>
                    <div class="row">
                        @foreach ($plans as $key => $plan)
                            <div class="col-lg-4 col-md-6 col-12" style="padding-top: 10px !important;">
                                <div class="basic-plans">
                                    <div class="basic-plans-top">
                                        <h3>
                                            {{ $plan->name }}
                                        </h3>
                                        <ul>
                                            <li class="d-flex align-items-center">
                                                <div class="plan-card-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                         viewBox="0 0 25 25" fill="none">
                                                        <path
                                                            d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"
                                                            fill="#24C6E3" />
                                                    </svg>
                                                </div>
                                                <div class="plan-card-content">
                                                    <p>{{ $plan->duration . ' ' . $plan->durationtype }}
                                                        {{ __('Duration') }}</p>
                                                </div>
                                            </li>
{{--                                            <li class="d-flex align-items-center">--}}
{{--                                                <div class="plan-card-icon">--}}
{{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"--}}
{{--                                                         viewBox="0 0 25 25" fill="none">--}}
{{--                                                        <path--}}
{{--                                                            d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"--}}
{{--                                                            fill="#24C6E3" />--}}
{{--                                                    </svg>--}}
{{--                                                </div>--}}
{{--                                                <div class="plan-card-content">--}}
{{--                                                    <p>{{ $plan->max_users . ' ' . __('Users') }}</p>--}}
{{--                                                </div>--}}
{{--                                            </li>--}}
{{--                                            <li class="d-flex align-items-center">--}}
{{--                                                <div class="plan-card-icon">--}}
{{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"--}}
{{--                                                         viewBox="0 0 25 25" fill="none">--}}
{{--                                                        <path--}}
{{--                                                            d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"--}}
{{--                                                            fill="#24C6E3" />--}}
{{--                                                    </svg>--}}
{{--                                                </div>--}}
{{--                                                <div class="plan-card-content">--}}
{{--                                                    <p>{{ $plan->max_roles . ' ' . __('Roles') }}</p>--}}
{{--                                                </div>--}}
{{--                                            </li>--}}
                                            <li class="d-flex align-items-center">
                                                <div class="plan-card-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                         viewBox="0 0 25 25" fill="none">
                                                        <path
                                                            d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"
                                                            fill="#24C6E3" />
                                                    </svg>
                                                </div>
                                                <div class="plan-card-content">
                                                    <p>{{ $plan->max_form . ' ' . __('Forms') }}</p>
                                                </div>
                                            </li>
{{--                                            <li class="d-flex align-items-center">--}}
{{--                                                <div class="plan-card-icon">--}}
{{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"--}}
{{--                                                         viewBox="0 0 25 25" fill="none">--}}
{{--                                                        <path--}}
{{--                                                            d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"--}}
{{--                                                            fill="#24C6E3" />--}}
{{--                                                    </svg>--}}
{{--                                                </div>--}}
{{--                                                <div class="plan-card-content">--}}
{{--                                                    <p>{{ $plan->max_booking . ' ' . __('Bookings') }}</p>--}}
{{--                                                </div>--}}
{{--                                            </li>--}}
{{--                                            <li class="d-flex align-items-center">--}}
{{--                                                <div class="plan-card-icon">--}}
{{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"--}}
{{--                                                         viewBox="0 0 25 25" fill="none">--}}
{{--                                                        <path--}}
{{--                                                            d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"--}}
{{--                                                            fill="#24C6E3" />--}}
{{--                                                    </svg>--}}
{{--                                                </div>--}}
{{--                                                <div class="plan-card-content">--}}
{{--                                                    <p>{{ $plan->max_documents . ' ' . __('Documents') }}</p>--}}
{{--                                                </div>--}}
{{--                                            </li>--}}
{{--                                            <li class="d-flex align-items-center">--}}
{{--                                                <div class="plan-card-icon">--}}
{{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"--}}
{{--                                                         viewBox="0 0 25 25" fill="none">--}}
{{--                                                        <path--}}
{{--                                                            d="M12.5 0C5.59642 0 0 5.59642 0 12.5C0 19.4036 5.59642 25 12.5 25C19.4036 25 25 19.4036 25 12.5C25 5.59642 19.4036 0 12.5 0ZM18.6178 10.737L12.2264 16.5232C12.0697 16.6652 11.8871 16.7607 11.6958 16.8108C11.5309 16.8843 11.3539 16.9223 11.1763 16.9223C10.8601 16.9223 10.5434 16.8058 10.2958 16.5709L6.36058 12.8354C5.84833 12.3491 5.82742 11.5397 6.31367 11.0274C6.7995 10.5152 7.60917 10.494 8.12167 10.9803L11.2539 13.9535L16.9009 8.84058C17.4244 8.36658 18.2332 8.40658 18.7072 8.93025C19.1812 9.454 19.1412 10.2627 18.6178 10.737Z"--}}
{{--                                                            fill="#24C6E3" />--}}
{{--                                                    </svg>--}}
{{--                                                </div>--}}
{{--                                                <div class="plan-card-content">--}}
{{--                                                    <p>{{ $plan->max_polls . ' ' . __('Polls') }}</p>--}}
{{--                                                </div>--}}
{{--                                            </li>--}}
                                        </ul>
                                    </div>
                                    <div class="basic-plans-bottom justify-content-between d-flex align-items-center">
                                        <div class="basic-plans-price d-flex">
                                            <div class="basic-price-left">
                                                <p>{{ __('Billed') }}</p>
                                                <ins>{{ Utility::amountFormat($plan->price) }} </ins>
                                            </div>
                                            <div class="basic-price-right">

                                            </div>
                                        </div>
                                        <div class="basic-plans-button d-flex">
                                            @if ($plan->id == 1)
{{--                                                <a style="background-color: #EC367E; border:none;"--}}
{{--                                                   onmouseover="this.style.backgroundColor='#FFAABB';"--}}
{{--                                                   onmouseout="this.style.backgroundColor='#EC367E';"--}}
{{--                                                   href="{{ route('requestuser.create', Crypt::encrypt(['plan_id' => $plan->id])) }}"--}}
{{--                                                   class="mt-2 subscribe_plan btn btn-primary btn-block"--}}
{{--                                                   data-id="{{ $plan->id }}"--}}
{{--                                                   data-amount="{{ $plan->price }}">{{ __('Free') }}--}}
{{--                                                    <i class="ti ti-chevron-right ms-2"></i></a>  --}}
                                                <a style="background-color: #EC367E; border:none;"
                                                   onmouseover="this.style.backgroundColor='#FFAABB';"
                                                   onmouseout="this.style.backgroundColor='#EC367E';"
                                                   href="/login"
                                                   class="mt-2 subscribe_plan btn btn-primary btn-block">{{ __('Free') }}
                                                    <i class="ti ti-chevron-right ms-2"></i></a>
                                            @elseif ($plan->id != 1)
{{--                                                <a href="{{ route('requestuser.create', Crypt::encrypt(['plan_id' => $plan->id])) }}"--}}
{{--                                                   class="mt-2 subscribe_plan btn btn-primary btn-block"--}}
{{--                                                   data-id="{{ $plan->id }}"--}}
{{--                                                   data-amount="{{ $plan->price }}">{{ __('Subscribe') }}--}}
{{--                                                    <i class="ti ti-chevron-right ms-2"></i></a>--}}
                                                <a href="/login"
                                                   class="mt-2 subscribe_plan btn btn-primary btn-block">{{ __('Subscribe') }}
                                                    <i class="ti ti-chevron-right ms-2"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if (Utility::keysettings('contactus_setting_enable', 1) == 'on')
                        <div class="custom-pricing-div d-flex align-items-center justify-content-between">
                            <div class="custom-pricing-left">
                                <h4>
                                    <b>{{ Utility::keysettings('contactus_name', 1) ? Utility::keysettings('contactus_name', 1) : __('Enterprise') }}</b>
                                    {{ Utility::keysettings('contactus_bold_name', 1) ? Utility::keysettings('contactus_bold_name', 1) : __('Custom pricing') }}
                                </h4>
                            </div>
                            <div class="custom-pricing-center">
                                <p>
                                    {{ Utility::keysettings('contactus_detail', 1)
                                        ? Utility::keysettings('contactus_detail', 1)
                                        : __('Offering tiered pricing options based on different levels of features or services allows
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        customers.') }}
                                </p>
                            </div>
                            <div class="custom-pricing-right">
                                <a href="{{ route('contactus') }}" class="btn">{{ __('Contact us') }}</a>
                            </div>
                        </div>
                    @endif
                    {{--  <img src="{{ asset('vendor/landing-page2/image/features-bg-image.png') }}" alt="bacground-image"
                        class="pricing-bg">  --}}
                </div>
            </section>
        @endif

        {{--  End Pricing Section  --}}



        {{-- Faq Section ----------  --}}

        @if (Utility::keysettings('faq_setting_enable', 1) == 'on')
            <section class="home-faqs-sec" id="faqs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="faqs-left-div">
                                <h2 class="">
                                    {{ Utility::keysettings('faq_name', 1) ? Utility::keysettings('faq_name', 1) : 'Frequently <span class="faq-heading">asked</span> questions' }}
                                </h2>
                                <a href="{{ route('faqs.pages') }}" class="btn">View All FAQs
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="11"
                                         viewBox="0 0 17 11" fill="none">
                                        <path
                                            d="M15.8434 6.63069L12.4502 10.6141C12.2632 10.8337 12.0181 10.9434 11.773 10.9434C11.5279 10.9434 11.2828 10.8337 11.0958 10.6141C10.7218 10.175 10.7218 9.46319 11.0958 9.02412L12.8541 6.96L1.75847 6.96C1.22956 6.96 0.800781 6.45664 0.800781 5.83572C0.800781 5.21479 1.22956 4.71143 1.75847 4.71143L12.8541 4.71143L11.0958 2.64731C10.7218 2.20825 10.7218 1.4964 11.0958 1.05733C11.4698 0.61826 12.0762 0.61826 12.4502 1.05733L15.8434 5.04074C16.2174 5.47977 16.2174 6.19166 15.8434 6.63069Z"
                                            fill="white" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="faqs-right-div">
                                @foreach ($faqs as $faq)
                                    <div class="set has-children">
                                        <a href="javascript:;" class="nav-label">
                                            <span class="blue-color">{{ $faq->question }}</span>
                                        </a>
                                        <div class="nav-list">
                                            <p>{!! $faq->answer !!}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <img src="{{ asset('vendor/landing-page2/image/test-bg.png') }}" alt="bacground-image"
                                     class="faqs-bg">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{--  End Faq Section  --}}


        <div id=""></div>
        <a href="#"
           class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

@endsection
