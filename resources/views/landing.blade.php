<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    <title>PolizzaCerta | How it works?</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{asset('images/landing/logo.png')}}" type="image/x-icon" />
    <!-- Bootstrap 4.5 -->
    <link rel="stylesheet" href="{{ asset('css/landing/bootstrap.min.css') }}" type="text/css" />
    <!-- animate -->
    <link rel="stylesheet" href="{{ asset('css/landing/animate.css') }}" type="text/css" />
    <!-- Swiper -->
    <link rel="stylesheet" href="{{ asset('css/landing/swiper.min.css') }}" />
    <!-- icons -->
    <link rel="stylesheet" href="{{ asset('css/landing/icons.css') }}" type="text/css" />
    <!-- aos -->
    <link rel="stylesheet" href="{{ asset('css/landing/aos.css') }}" type="text/css" />
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('css/landing/main.css') }}" type="text/css" />
    <!-- normalize -->
    <link rel="stylesheet" href="{{ asset('css/landing/normalize.css') }}" type="text/css" />
    <!-- polizzacerta -->
    <link rel="stylesheet" href="{{ asset('css/landing/polizzacerta.css') }}" type="text/css" />


    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">


    <!-- js for Brwoser -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div id="wrapper">
    <div id="content">
        <!-- Start header -->
        <header class="header-nav-center no_blur white-scroll-dark active-blue" id="myNavbar">
            <div class="container">
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light header-nav-left nav-product">
                    <a class="navbar-brand" href="/">
                        <img class="logo" src="{{asset('images/landing/logo.png')}}" alt="logo" />
                        <span class="polizzacerta d-lg-inline d-none">POLIZZA<b>CERTA</b></span>
                    </a>

                    <button class="navbar-toggler menu ripplemenu" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <svg viewBox="0 0 64 48">
                            <path d="M19,15 L45,15 C70,15 58,-2 49.0177126,7 L19,37"></path>
                            <path d="M19,24 L45,24 C61.2371586,24 57,49 41,33 L32,24"></path>
                            <path d="M45,33 L19,33 C-8,33 6,-2 22,14 L45,37"></path>
                        </svg>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto nav-pills">

                            <li class="nav-item">
                                <a class="nav-link c-red" href="/">{{ $phrases['verify_your_policy'] }}</a>
                            </li>

                        </ul>

                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
            <!-- end container -->
        </header>
        <!-- End header -->
        <!-- Stat main -->

        <main data-spy="scroll" data-target="#navbar-example2" data-offset="0">
            <!-- Start Banner Section -->
            <section class="demo_1 banner_comefunziona banner_section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 mb-5">
                            <div class="banner_title">
                                <div class="offer">
                                    <span class="c-white">100%</span>
                                    <span class="c-aquamarine"> {{$phrases['ultra-technology'] }}</span>
                                </div>
                                <h1 class="c-white">
                                    {{ $phrases['we-check-if-your-policy-exists'] }}
                                </h1>
                                <p class="c-light">
                                    {{ $phrases['no-more-fake-policies-help-us-make-the-insurance-world-a-better-place'] }}
                                </p>
                            </div>
                            <a href="#Services" class="btn btn_md_primary bg-red effect-letter rounded-8 c-white mb-3 mb-sm-0 mr-2">
                                {{ $phrases['learn-more'] }}</a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Banner -->

            <!-- Start logos -->
            <section class="logos_section padding-t-5 text-center">
                <div class="container">
                    <h3>{{$phrases['trusted-by-insurance-companies-across-the-world'] }}</h3>
                    <div class="row justify-content-md-center">
                        <div class="col-md-10">
                            <div class="wrapper_logos">
                                <div class="items bxslider">
                                    <a class="item-client" href="#" target="_blank">
                                        <img src="{{asset('images/landing/companies/1.png')}}" alt="" />
                                        <span>Visit site</span>
                                    </a>
                                    <a class="item-client" href="#" target="_blank">
                                        <img src="{{asset('images/landing/companies/2.png')}}" alt="" />
                                        <span>Visit site</span>
                                    </a>
                                    <a class="item-client" href="#" target="_blank">
                                        <img src="{{asset('images/landing/companies/3.png')}}" alt="" />
                                        <span>Visit site</span>
                                    </a>
                                </div>
                                <div class="logos_masks"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End logos -->

            <!-- Start Services -->
            <section class="services_section hosting_service padding-t-12" id="Services">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-lg-4">
                            <div class="title_sections mb-0">
                                <div class="img_title">
                                    <img src="{{asset('images/landing/hosting/54.svg')}}" />
                                </div>
                                <h2>{{ $phrases['polizacerta-in-a-word-super'] }}</h2>
                                <p>
                                    {{ $phrases['no-longer-be-afraid-to-take-out-fake-policies-check-with-us-for-the-existence-of-your-insurance-coverage'] }}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 ml-auto">
                            <div class="row">
                                <div class="col-md-6 item">
                                    <div class="items_serv sevice_block" data-aos="fade-up" data-aos-delay="0">
                                        <div class="icon--top">
                                            <img src="{{asset('images/landing/icons/Settings.svg')}}" alt="" />
                                        </div>
                                        <div class="txt">
                                            <h3>{{ $phrases['super-easy'] }}</h3>
                                            <p>
                                                {{ $phrases['simply-enter-the-policy-number-and-your-tax-code-to-verify-the-existence-of-the-contract'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 item">
                                    <div class="items_serv sevice_block" data-aos="fade-up" data-aos-delay="100">
                                        <div class="icon--top">
                                            <img src="{{asset('images/landing/icons/Layers.svg')}}" alt="" />
                                        </div>
                                        <div class="txt">
                                            <h3>{{ $phrases['super-tecnologia']}}</h3>
                                            <p>
                                                {{ $phrases['every-day-we-advance-technologically-and-invest-as-much-as-possible-on-security'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 item">
                                    <div class="items_serv sevice_block" data-aos="fade-up" data-aos-delay="200">
                                        <div class="icon--top">
                                            <img src="{{asset('images/landing/icons/Thunder-move.svg')}}" alt="" />
                                        </div>
                                        <div class="txt">
                                            <h3>{{ $phrases['super-privacy'] }}</h3>
                                            <p>
                                                {{ $phrases['our-algorithms-are-so-advanced-that-you-don\'t-need-to-store-your-sensitive-data'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 item">
                                    <div class="items_serv sevice_block" data-aos="fade-up" data-aos-delay="300">
                                        <div class="icon--top">
                                            <img src="{{asset('images/landing/icons/Headphones.svg')}}" alt="" />
                                        </div>
                                        <div class="txt">
                                            <h3>{{ $phrases['super-service'] }}</h3>
                                            <p>
                                                {{ $phrases['if-you-have-doubts-or-difficulties-our-switchboard-is-at-your-disposal-and-we-look-forward-to-helping-you'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Services -->

            <!-- Start Section Products -->
            <section class="products_section product_demo2 features_hosting margin-t-12 padding-py-12" id="Features">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-lg-4 margin-b-3">
                            <div id="target1"></div>
                            <div class="title_sections" id="pin1">
                                <h2>{{ $phrases['how-does-polizzacerta-work'] }}</h2>
                                <p>
                                    {{ $phrases['lots-of-algorithms-lots-of-technology-and-a-bit-of-magic'] }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-7 ml-sm-auto">
                            <div class="row">
                                <div class="col-md-6 item pr-sm-5 margin-b-5">
                                    <div class="item_pro" data-aos="fade-up" data-aos-delay="0">
                                        <div class="icon_t">
                                            <img src="{{asset('images/landing/icons/Employee.svg')}}" />
                                        </div>
                                        <h3>1. {{ $phrases['buy-insurance'] }}</h3>
                                        <p>
                                            {{ $phrases['buy-your-insurance-as-you-always-have-from-your-insurer-or-online'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 item pr-sm-5 margin-b-5">
                                    <div class="item_pro" data-aos="fade-up" data-aos-delay="100">
                                        <div class="icon_t">
                                            <img src="{{asset('images/landing/icons/Binocular.svg')}}" />
                                        </div>
                                        <h3>2. {{ $phrases['receive-the-contract'] }}</h3>
                                        <p>
                                            {{ $phrases['the-insurance-of-send-the-insurance-contract-and-believe-that-you-are-insured'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 item pr-sm-5 margin-b-5">
                                    <div class="item_pro" data-aos="fade-up" data-aos-delay="200">
                                        <div class="icon_t">
                                            <img src="{{asset('images/landing/icons/Shield-check.svg')}}" />
                                        </div>
                                        <h3>3. {{ $phrases['verification-of-the-contract'] }}</h3>
                                        <p>
                                            {{ $phrases['if-you-purchased-the-policy-from-one-of-our-partners-we-verify-its-existence'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 item pr-sm-5 margin-b-5">
                                    <div class="item_pro" data-aos="fade-up" data-aos-delay="0">
                                        <div class="icon_t">
                                            <img src="{{asset('images/landing/icons/Door-open.svg')}}" />
                                        </div>
                                        <h3>4. {{ $phrases['log-in-to-polizzacerta'] }}</h3>
                                        <p>
                                            {{ $phrases['by-accessing-polizzacerta-you-verify-that-the-contract-you-have-in-hand-is-not-waste-paper'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 item pr-sm-5 margin-b-5">
                                    <div class="item_pro" data-aos="fade-up" data-aos-delay="100">
                                        <div class="icon_t">
                                            <img src="{{asset('images/landing/icons/Support.svg')}}" />
                                        </div>
                                        <h3>{{ $phrases['doubts-of-fears'] }}</h3>
                                        <p>
                                            {{ $phrases['our-support-team-is-happy-to-help-those-in-doubt-that-they-have-been-scammed'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 item pr-sm-5 margin-b-5">
                                    <div class="item_pro" data-aos="fade-up" data-aos-delay="200">
                                        <div class="icon_t">
                                            <img src="{{asset('images/landing/icons/Angle-double-up.svg')}}" />
                                        </div>
                                        <h3>{{ $phrases['no-more-fake-policies'] }}</h3>
                                        <p>
                                            {{ $phrases['help-us-take-the-insurance-market-to-the-next-level-we-can-do-it-together'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .container -->
            </section>
            <!-- End Section Products -->

            <!-- Start money section -->
            <section class="money_section padding-t-3 margin-t-12">
                <div class="container">
                    <div class="row justify-content-center text-center">
                        <div class="col-md-12 col-lg-12">
                            <div class="title_sections">
                                <h2>{{ $phrases['ps-we-forgot-a-little-detail-our-service-is-free-and-does-not-require-any-registration'] }}</h2>
                            </div>
                            <a href="/" class="btn btn_lg_primary rounded-8 c-white effect-letter bg-red">{{ $phrases['check-your-policy-now'] }}</a>
                        </div>
                        <img class="img_hand" src="{{asset('images/landing/hosting/hands.svg')}}" />
                    </div>
                </div>
            </section>
            <!-- End. money -->

            <!-- Start FAQ -->
            <section class="faq_section faq_demo3">
                <div class="container">
                    <div class="padding-t-12" id="faq">
                        <div class="row justify-content-md-center">
                            <div class="col-md-8 col-lg-6 text-center">
                                <div class="title_sections">
                                    <div class="before_title">
                                        <span>{{ $phrases['frequently-asked'] }}</span>
                                        <span class="c-red">{{ $phrases['questions'] }}</span>
                                    </div>
                                    <h2>{{ $phrases['want-to-ask-something-from-us'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <!-- block Collapse -->
                        <div class="block_faq">
                            <div class="accordion" id="accordionExample">
                                <div class="row justify-content-md-center">
                                    <div class="col-md-6 col-lg-5">
                                        <div class="card">
                                            <div class="card-header active" id="headingOne">
                                                <h3 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                        {{ $phrases['accordion-title-1'] }}
                                                    </button>
                                                </h3>
                                            </div>

                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                                 data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <p style="white-space: pre-wrap;">{{ $phrases['accordion-content-1-1'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingTwo">
                                                <h3 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo"
                                                            aria-expanded="true" aria-controls="collapseTwo">
                                                        {{ $phrases['accordion-title-2'] }}
                                                    </button>
                                                </h3>
                                            </div>

                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                 data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <p style="white-space: pre-wrap;">{{  $phrases['accordion-content-2-1'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingThree">
                                                <h3 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                                            data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                        {{ $phrases['accordion-title-3'] }}
                                                    </button>
                                                </h3>
                                            </div>

                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                                 data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <p style="white-space: pre-wrap;">{{ $phrases['accordion-content-3-1'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingFour">
                                                <h3 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                                            data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                        {{ $phrases['accordion-title-4'] }}
                                                    </button>
                                                </h3>
                                            </div>

                                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                                 data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <p style="white-space: pre-wrap;">{{ $phrases['accordion-content-4-1'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-5">
                                        <div class="card">
                                            <div class="card-header" id="headingFive">
                                                <h3 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                                            data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                                        {{  $phrases['accordion-title-5'] }}
                                                    </button>
                                                </h3>
                                            </div>

                                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                                                 data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <p style="white-space: pre-wrap;">{{ $phrases['accordion-content-5-1']  }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingSix">
                                                <h3 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseSix"
                                                            aria-expanded="true" aria-controls="collapseSix">
                                                        {{ $phrases['accordion-title-6'] }}
                                                    </button>
                                                </h3>
                                            </div>

                                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix"
                                                 data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <p style="white-space: pre-wrap;">{{ $phrases['accordion-content-6-1']}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingSeven">
                                                <h3 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                                            data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                                        {{ $phrases['accordion-title-7']  }}
                                                    </button>
                                                </h3>
                                            </div>

                                            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven"
                                                 data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <p style="white-space: pre-wrap;">{{  $phrases['accordion-content-7-1'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End FAQ -->

            <!-- Start Some help -->
            <section class="need_help_sec padding-t-12">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="block_help">
                                <div class="title_sections mb-0">
                                    <h2 class="c-white">{{ $phrases['do-you-need-help'] }}</h2>
                                    <p class="c-light">
                                        {{ $phrases['whether-you-are-having-trouble-verifying-your-policy-or-believe-you-have-been-scammed-our-support-team-is-at-your-disposal'] }}
                                    </p>
                                    <div class="item_help">
                                        <span class="c-aquamarine">{{ $phrases['contact-the-super-support-team'] }}</span>
                                        <p style="white-space: pre-wrap;">
{{ $phrases['contact-support-team'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4 mt-lg-0">
                            <img class="img_help" src="{{asset('images/landing/hosting/78.svg')}}" />
                        </div>
                    </div>
                </div>
            </section>
            <!-- End. some help -->


        </main>
        <!-- end main -->
    </div>
</div>
<!-- [id] content -->
<footer class="default_footer chiy_footer foot_demo2 padding-py-12 margin-t-12">
    <div class="container">
        <!-- Start footer -->
        <div class="defalut-footer">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-4 mb-sm-0">
                    <div class="item_about">
                        <a class="logo" style="font-size: 16px!important" href="#">
                            <img src="{{asset('images/landing/logo.png')}}" alt="" />
                            <span class="polizzacerta" style="font-size: 16px!important">POLIZZA<b>CERTA</b></span>
                        </a>
                        <div class="address">
                            <p style="white-space: pre-wrap;">{{ $phrases['contact-info'] }}<a class="c-red" href="tel: {{$phrases['phone']}}"> {{$phrases['phone']}}</a></p>

                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4">
                    <div class="item_links">
                        <a class="nav-link" href="{{$phrases['about_link']}}">{{ $phrases['about'] }}</a>
                            <a class="nav-link" href="{{$phrases['careers_link']}}">{{ $phrases['careers']  }}</a>
                        <a class="nav-link" href="{{$phrases['legal-privacy-link']}}">{{ $phrases['legal-privacy'] }}</a>
                    </div>
                </div>
                <div class="col-md-4 mt-4 mt-sm-0">
                    <div class="item_subscribe">
                        <h4>{{ $phrases['subscribe']  }}</h4>
                        <p>
                            {{ $phrases['subscribe-to'] }}
                        </p>
                        <form class="form-row" id="subscribe-form">
                            <div class="col-md-11 form-group subscribebtn">
                                <div class="item_input">
                                    <input type="email" class="form-control rounded-pill" id="exampleInputEmail1"
                                           placeholder="Enter email address" aria-describedby="emailHelp" required />
                                    <button type="submit" class="btn ripple_circle scale rounded-circle btn_subscribe">
                                        <i class="tio send"></i>
                                    </button>
                                </div>
                                <div class="input-group pl-0 d-flex align-items-center">
                                    <input class="form-check" style="width:17px;" type="checkbox" id="term_of_use" required>
                                    <label class="mb-0 ml-2" for="term_of_use" style="color: #9da6af;">{{ $phrases['i_agree'] }} <a href="{{$phrases['legal-privacy-link']}}">{{ $phrases['privacy_policy'] }}</a></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center padding-t-6">
                <div class="copyright">
              <span>© 2021
                <a href="https://www.polizzacerta.it" target="_blank">PolizzaCerta</a>
                All Right Reseved</span>
                </div>
            </div>
        </div>
        <!-- End Footer -->
    </div>
</footer>

<!-- Back to top with progress indicator-->
<div class="prgoress_indicator">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>

<!-- Tosts -->
<div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center">
    <div class="toast toast_demo" id="myTost" role="alert" aria-live="assertive" aria-atomic="true"
         data-animation="true" data-autohide="false">
        <div class="toast-body">
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <i class="tio clear"></i>
            </button>
            <h5>{{ $phrases['hey']}}</h5>
            <p>{{ $phrases['want-back']}} <a href="/">{{ $phrases['click-here']}}</a></p>
        </div>
    </div>
</div>
<!-- End. Toasts -->

<!-- Start Section Loader -->
<section class="loading_overlay">
    <div class="loader_logo">
        <img class="logo" src="{{asset('images/landing/logo.png/')}}" />
    </div>
</section>
<!-- End. Loader -->




<!-- jquery -->
<script src="{{ asset('js/landing/jquery-3.5.0.js') }}" type="text/javascript"></script>
<!-- jquery-migrate -->
<script src="{{ asset('js/landing/jquery-migrate.min.js') }}" type="text/javascript"></script>
<!-- popper -->
<script src="{{ asset('js/landing/popper.min.js') }}" type="text/javascript"></script>
<!-- bootstrap -->
<script src="{{ asset('js/landing/bootstrap.min.js') }}" type="text/javascript"></script>
<!--
============
vendor file
============
 -->
<!-- particles -->
<script src="{{ asset('js/landing/vendor/particles.min.js') }}" type="text/javascript"></script>
<!-- TweenMax -->
<script src="{{ asset('js/landing/vendor/TweenMax.min.js') }}" type="text/javascript"></script>
<!-- ScrollMagic -->
<script src="{{ asset('js/landing/vendor/ScrollMagic.js') }}" type="text/javascript"></script>
<!-- animation.gsap -->
<script src="{{ asset('js/landing/vendor/animation.gsap.js') }}" type="text/javascript"></script>
<!-- addIndicators -->
<script src="{{ asset('js/landing/vendor/debug.addIndicators.min.js') }}" type="text/javascript"></script>
<!-- Swiper js -->
<script src="{{ asset('js/landing/vendor/swiper.min.js') }}" type="text/javascript"></script>
<!-- countdown -->
<script src="{{ asset('js/landing/vendor/countdown.js') }}" type="text/javascript"></script>
<!-- simpleParallax -->
<script src="{{ asset('js/landing/vendor/simpleParallax.min.js') }}" type="text/javascript"></script>
<!-- waypoints -->
<script src="{{ asset('js/landing/vendor/waypoints.min.js') }}" type="text/javascript"></script>
<!-- counterup -->
<script src="{{ asset('js/landing/vendor/jquery.counterup.min.js') }}" type="text/javascript"></script>
<!-- charming -->
<script src="{{ asset('js/landing/vendor/charming.min.js') }}" type="text/javascript"></script>
<!-- imagesloaded -->
<script src="{{ asset('js/landing/vendor/imagesloaded.pkgd.min.js') }}" type="text/javascript"></script>
<!-- BX-Slider -->
<script src="{{ asset('js/landing/vendor/jquery.bxslider.min.js') }}" type="text/javascript"></script>
<!-- Sharer -->
<script src="{{ asset('js/landing/vendor/sharer.js') }}" type="text/javascript"></script>
<!-- sticky -->
<script src="{{ asset('js/landing/vendor/sticky.min.js') }}" type="text/javascript"></script>
<!-- Aos -->
<script src="{{ asset('js/landing/vendor/aos.js') }}" type="text/javascript"></script>
<!-- main file -->
<script src="{{ asset('js/landing/main.js') }}" type="text/javascript"></script>
<!-- hosting -->
<script src="{{ asset('js/landing/pages/hosting.js') }}" type="text/javascript"></script>
<!--Alertify-->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<script type="text/javascript">
    var _iub = _iub || [];
    _iub.csConfiguration = {"countryDetection":true,"lang":"{{\Illuminate\Support\Facades\App::getLocale()}}","siteId":2409101,"floatingPreferencesButtonDisplay":"bottom-right","consentOnContinuedBrowsing":false,"cookiePolicyId":45354605, "banner":{ "acceptButtonDisplay":true,"customizeButtonDisplay":true,"acceptButtonColor":"#9bd639","acceptButtonCaptionColor":"white","customizeButtonColor":"rgba(33.8, 33.8, 33.8, 0.46)","customizeButtonCaptionColor":"white","rejectButtonColor":"#e3a134","rejectButtonCaptionColor":"white","position":"float-top-center","textColor":"#ffffff","backgroundColor":"rgba(0, 0, 1.92, 0.37)","rejectButtonDisplay":true,"listPurposes":true }};
</script>
<script type="text/javascript" src="//cdn.iubenda.com/cs/iubenda_cs.js" charset="UTF-8" async></script>


<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
<script>
    $("#subscribe-form").submit(function (e) {
        let current = e.preventDefault();

        $.ajax({
            method: "POST",
            url: '/subscribe',
            data:
                {
                    '_token': "{{ csrf_token() }}",
                    'email': $('#exampleInputEmail1').val(),
                }
            ,
            // serializes the form's elements.
            success: function (data) {
                alertify.success('{{$phrases['subscribe-message']}}');
                $('#exampleInputEmail1').val('');
            }
        });
    })
</script>

</body>

</html>
