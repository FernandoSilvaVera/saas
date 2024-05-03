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

                <!-- App_section -->
                <section class="app_section section_padding_bg">
                    <div class="container-fluid">
                        <div class="app_top pb_24 d-flex align-items-center justify-content-between">
                            <div class="select app_top_select">

                                <div class="selected_tab">
                                    <p class="text_sm selected_text">Selecciona una plantilla</p>
                                    <!-- arrow_down_app -->
                                    <div class="arrow_down_app">
                                        <img src="./img/arrow_down_app.svg" alt="">
                                    </div>
                                </div>


                                <div class="select_tab_dropdown" id="myTab" role="tablist">
					@foreach($templates as $template)
						<button onclick="useTemplate({{$template}})" id="{{$template->id}}" class="select_tab">{{ $template->template_name }}</button>
					@endforeach
                                </div>


                            </div>

                            <div class="apptop_right d-flex">
                                <a href="#" class="button button_trasparent mr_20">Upload Files</a>
                                <a href="#" class="button button_trasparent">Upload Files</a>
                            </div>
                        </div>

                                <div class="preview_template section_padding_bg">
					@include('includes/template')
				</div>

			</div>
                    </div>
                </section>

            </div>
        </div>
    </div>


    <!-- all js here -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
