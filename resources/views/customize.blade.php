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
                </div>

            </div>

            <!-- main_content -->
            <div class="main_content pl_24 pr_24 pb_60 w-100">

                <!-- Create user Section -->
                <div class="create_user_page">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="section_padding_bg">
                                    <div class="pb_15">
                                        <h4 class="pb_10">Maximum words <img src="./img/exclamation.svg"
                                                class="exclamation_icon" alt=""></h4>
                                        <h2>395</h2>
                                    </div>
                                    <div class="pb_15">
                                        <h4 class="pb_10">Multiple choice questions <img src="./img/exclamation.svg"
                                                class="exclamation_icon" alt=""></h4>
                                        <h2>395</h2>
                                    </div>
                                    <div class="pb_15">
                                        <h4 class="pb_10">Number of summaries <img src="./img/exclamation.svg"
                                                class="exclamation_icon" alt=""></h4>
                                        <h2>395</h2>
                                    </div>
                                    <div class="pb_15">
                                        <h4 class="pb_5">Voiceover <img src="./img/exclamation.svg"
                                                class="exclamation_icon" alt=""></h4>
                                        <div class="check_box active">
                                            <div class="check">
                                                <img src="./img/check_mark.svg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="Editors pb_5">Editors <img src="./img/exclamation.svg"
                                                class="exclamation_icon ml_5" alt=""></h4>
                                        <div class="check_box active">
                                            <div class="check">
                                                <img src="./img/check_mark.svg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-9">
                                <div class="Create_user section_padding_bg">
                                    <div class="container-fluid">
                                        <div class="contact_top pb_24">
                                            <h2>Customize subscriptions</h2>
                                        </div>

                                        <form action="#" class="contact_form account_info">
                                            <div class="form_groups d-flex gap_24 pb_20 align-items-center">
                                                <div class="form_group w-50">
                                                    <label for="Name" class="d-flex pb_10">Subscription Name</label>
                                                    <input type="text" class="input_field w-100"
                                                        placeholder="Monthly Pack 2" required>
                                                </div>
                                                <div class="form_group w-50">
                                                    <label for="details" class="d-flex pb_10">Package & billing
                                                        details</label>
                                                    <input type="text" class="input_field w-100" placeholder="$10"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="form_group w-100 pb_20">
                                                <label for="Expire" class="d-flex pb_10">Expire date</label>
                                                <input type="text" class="input_field w-100"
                                                    placeholder="August 26,2025" required>
                                            </div>
                                            <div class="form_group w-100">
                                                <label for="FName" class="d-flex pb_10">Remaining post</label>
                                                <textarea name="message" class="w-100" placeholder="0"></textarea>
                                            </div>
                                        </form>
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
