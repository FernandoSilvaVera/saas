<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="img/favicon.svg" type="image/png" rel="icon">

    <!-- all css here -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/helper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    </head>
<body class="antialiased">

    <div class="dashboard align-items-start">

        <!-- overlay -->
        <div class="overlay d-lg-none d-block"></div>

        <!-- sidebar -->
        <div class="sidebar">
            <a href="#" class="logo">
                <img src="./img/logo.svg" alt="">
            </a>

		@include('includes/primary_menu')

        </div>

        <!-- main_content_wrap -->
        <div class="main_content_wrap">

            <!-- main_content_header -->
            <div class="main_content_header pl_24 pr_24 pt_24 pb_24 d-flex justify-content-between w-100">
                <div class="header_left gap_24 d-flex">
                    <div class="hamburger d-lg-none d-flex">
                        <img src="./img/hamburger.svg" class="hamburger_bar" alt="">
                        <img src="./img/close.svg" class="close" alt="">
                    </div>
                    <h1>Plans</h1>
                </div>

                <div class="header_right d-flex gap_24 align-items-center">
                    <a href="#">
                        <img src="./img/notification.svg" class="w_24" alt="">
                    </a>
                    <a href="#" class="">
                        <img src="./img/setting.svg" class="w_24" alt="">
                    </a>
                    <a href="#">
                        <img src="./img/header_img.png" class="header_img" alt="">
                    </a>
                </div>
            </div>

            <!-- main_content -->
            <div class="main_content pl_24 pr_24 pb_60 w-100">

                <!-- Modal -->
                <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="login_modalTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <button type="button" class="modal_close" data-dismiss="modal" aria-label="Close">
                                <img src="./img/cross.svg" alt="">
                            </button>
                            <div class="modal-body">
                                <div class="modal_content">
                                    <a href="#" class="logo x_center">
                                        <img src="./img/logo.svg" alt="">
                                    </a>
                                    <h2 class="pt_24 pb_24 text-center">Welcome Back</h2>
                                    <a href="#" class="text_sm google_login x_center"><img src="./img/google.svg"
                                            class="google_icon" alt="">Log in
                                        with Google</a>

                                    <div class="separator pt_24 pb_24 text-center">
                                        <p class="text_xsm">OR</p>
                                    </div>

                                    <form action="#" class="account-info">
                                        <div class="form_group pb_24 w-100">
                                            <label for="Email" class="d-flex pb_10">Type here</label>
                                            <div class="show_hide_warp position-relative">
                                                <input type="email" class="input_field w-100" value="example@gmail.com"
                                                    required>
                                                <div class="show_hide">
                                                    <div class="eye eye_uncut">
                                                        <img src="./img/eye.svg" alt="">
                                                    </div>
                                                    <div class="eye eye_cut">
                                                        <img src="./img/eye-slash.svg" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form_group w-100 account_info_form_group align-items-end">
                                            <div class="form_inner_wrap">
                                                <label for="Password" class="d-flex pb_10">Password</label>
                                                <div class="show_hide_warp position-relative">
                                                    <input type="password" class="input_field w-100"
                                                        value="*****************" required>
                                                    <div class="show_hide">
                                                        <div class="eye eye_uncut">
                                                            <img src="./img/eye.svg" alt="">
                                                        </div>
                                                        <div class="eye eye_cut">
                                                            <img src="./img/eye-slash.svg" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text_xsm pt_10">At least 8 characters and one number.</p>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="check_box active pt_24 pb_24 d-flex align-items-center ">
                                        <div class="check">
                                            <img src="./img/check_mark.svg" alt="">
                                        </div>
                                        <p class="text_sm pl_10">Remember me</p>
                                    </div>

                                    <button type="submit" class="button w-100">Log in</button>

                                    <p class="text_xsm pt_24 text-center">Don’t have an account? <a href="#">Sign up</a>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- price page top -->
                <div class="price_page_top pt_30 pb_30 pl_35 pr_35 mb_25 bg-white rounded_lg">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2>You need a more personalized plan?</h2>
                        </div>
                        <div class="col-lg-4  d-flex align-items-center justify-content-end">
                            <button data-bs-toggle="modal" data-bs-target="#login_modal" class="button">Contact us
                            </button>
                        </div>
                    </div>

                </div>

                <!-- price_section -->
                <div class="price_section">
                    <div class="container-fluid">
                        <div class="price_top pb_24">
                            <h2 class="pb_10">Choose Your Plans</h2>
                            <p>You will bw charged for the plan after the admin approves your vendor
                                account</p>
                        </div>

                        <div class="nav nav-tabs price_tabs monthly-tab" id="myTab" role="tablist">
                            <button class="nav-link price_tab active" id="monthly-tab" data-bs-toggle="tab"
                                data-bs-target="#monthly" type="button" role="tab" aria-controls="monthly"
                                aria-selected="true">
                                Monthly
                            </button>
                            <button class="nav-link price_tab" id="yearly-tab" data-bs-toggle="tab"
                                data-bs-target="#yearly" type="button" role="tab" aria-controls="yearly"
                                aria-selected="false">
                                Yearly
                            </button>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="monthly" role="tabpanel"
                                aria-labelledby="monthly-tab">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="price_box">
                                            <h5 class="price_title">Starter</h5>

                                            <h2 class="price"><span>$15</span> per month</h2>

                                            <div class="price_lists">
                                                <p>Unlimited Client</p>
                                                <p>Unlimited Invoice</p>
                                                <p>2 Staff</p>
                                                <p>250 Recurring Profile</p>
                                                <p>50 Auto-billing Profile</p>
                                                <p>1 GB File Storage</p>
                                            </div>

                                            <a href="#" class="button w-100">Get Started</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="price_box">
                                            <h5 class="price_title">Basic</h5>

                                            <h2 class="price"><span>$29</span> per month</h2>

                                            <div class="price_lists">
                                                <p>Unlimited Client</p>
                                                <p>Unlimited Invoice</p>
                                                <p>5 Staff</p>
                                                <p>500 Recurring Profile</p>
                                                <p>100 Auto-billing Profile</p>
                                                <p>2 GB File Storage</p>
                                            </div>

                                            <a href="#" class="button w-100">Get Started</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="price_box">
                                            <h5 class="price_title">Studio</h5>

                                            <h2 class="price"><span>$52</span> per month</h2>

                                            <div class="price_lists">
                                                <p>Unlimited Client</p>
                                                <p>Unlimited Invoice</p>
                                                <p>10 Staff</p>
                                                <p>1000 Recurring Profile</p>
                                                <p>250 Auto-billing Profile</p>
                                                <p>4 GB File Storage</p>
                                            </div>

                                            <a href="#" class="button w-100">Get Started</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="price_box">
                                            <h5 class="price_title">Company</h5>

                                            <h2 class="price"><span>$85</span> per month</h2>

                                            <div class="price_lists">
                                                <p>Unlimited Client</p>
                                                <p>Unlimited Invoice</p>
                                                <p>20 Staff</p>
                                                <p>Unlimited Recurring Profile</p>
                                                <p>500 Auto-billing Profile</p>
                                                <p>8 GB File Storage</p>
                                            </div>

                                            <a href="#" class="button w-100">Get Started</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="yearly" role="tabpanel" aria-labelledby="yearly-tab">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="price_box">
                                            <h5 class="price_title">Starter</h5>

                                            <h2 class="price"><span>$25</span> per month</h2>

                                            <div class="price_lists">
                                                <p>Unlimited Client</p>
                                                <p>Unlimited Invoice</p>
                                                <p>2 Staff</p>
                                                <p>250 Recurring Profile</p>
                                                <p>50 Auto-billing Profile</p>
                                                <p>1 GB File Storage</p>
                                            </div>

                                            <a href="#" class="button w-100">Get Started</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="price_box">
                                            <h5 class="price_title">Basic</h5>

                                            <h2 class="price"><span>$39</span> per month</h2>

                                            <div class="price_lists">
                                                <p>Unlimited Client</p>
                                                <p>Unlimited Invoice</p>
                                                <p>5 Staff</p>
                                                <p>500 Recurring Profile</p>
                                                <p>100 Auto-billing Profile</p>
                                                <p>2 GB File Storage</p>
                                            </div>

                                            <a href="#" class="button w-100">Get Started</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="price_box">
                                            <h5 class="price_title">Studio</h5>

                                            <h2 class="price"><span>$52</span> per month</h2>

                                            <div class="price_lists">
                                                <p>Unlimited Client</p>
                                                <p>Unlimited Invoice</p>
                                                <p>10 Staff</p>
                                                <p>1000 Recurring Profile</p>
                                                <p>250 Auto-billing Profile</p>
                                                <p>4 GB File Storage</p>
                                            </div>

                                            <a href="#" class="button w-100">Get Started</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="price_box">
                                            <h5 class="price_title">Company</h5>

                                            <h2 class="price"><span>$95</span> per month</h2>

                                            <div class="price_lists">
                                                <p>Unlimited Client</p>
                                                <p>Unlimited Invoice</p>
                                                <p>20 Staff</p>
                                                <p>Unlimited Recurring Profile</p>
                                                <p>500 Auto-billing Profile</p>
                                                <p>8 GB File Storage</p>
                                            </div>

                                            <a href="#" class="button w-100">Get Started</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- all js here -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>


</body>
</html>
