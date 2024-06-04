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

		@include('includes/login')

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

		@auth
		@else
			<div class="alert alert-success text-center" role="alert">
				Ese necesario iniciar sesión para poder suscribirse
			</div>
		@endauth

                <!-- price page top -->
                <div class="price_page_top pt_30 pb_30 pl_35 pr_35 mb_25 bg-white rounded_lg">




                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2>¿Necesitas un plan más personalizado?</h2>
                        </div>
                        <div class="col-lg-4  d-flex align-items-center justify-content-end">
                            <button class="button" onclick="window.location.href='/contact'">Contáctanos</button>
                        </div>
                    </div>
                </div>

                <!-- price_section -->
                <div class="price_section">
                    <div class="container-fluid">
                        <div class="nav nav-tabs price_tabs monthly-tab" id="myTab" role="tablist">
                            <button class="nav-link price_tab active" id="monthly-tab" data-bs-toggle="tab"
                                data-bs-target="#monthly" type="button" role="tab" aria-controls="monthly"
                                aria-selected="true">
                                Mensual
                            </button>
                            <button class="nav-link price_tab" id="yearly-tab" data-bs-toggle="tab"
                                data-bs-target="#yearly" type="button" role="tab" aria-controls="yearly"
                                aria-selected="false">
                                Anual
                            </button>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="monthly" role="tabpanel"
                                aria-labelledby="monthly-tab">
                                <div class="row">

					@foreach($plans as $plan)

					    <div class="col-lg-3 col-md-6">
						<div class="price_box">
						    <h5 class="price_title">{{$plan->name}}</h5>

						    <div class="price_lists">
							<p><strong>Limite de palabras:</strong> {{$plan->word_limit}}</p>
							<p><strong>Nº Resumenes:</strong> {{$plan->summaries}}</p>
							<p><strong>Nº Test:</strong> {{$plan->test_questions_count}}</p>
							<p><strong>Nº Editores:</strong> {{$plan->editors_count}}</p>
							<p><strong>Nº Mapas conceptuales:</strong> {{$plan->concept_map}}</p>
							@if ($plan->voiceover > 0)
								<p><strong>Locución en línea:</strong> {{$plan->voiceover}}</p>
						        @endif
						    </div>

							@if(isset($plan->is_client_plan) && $plan->is_client_plan)
								<a href="/unsubscribe/{{$plan->id}}" class="buttonRed w-100">Darse de baja</a>
							@else
								<a href="/buy/{{$plan->stripe_monthly_price_id}}" class="button w-100">{{$plan->monthly_price}}€ / mes</a>
							@endif

						</div>
					    </div>

					@endforeach

                                </div>
                            </div>
                            <div class="tab-pane fade" id="yearly" role="tabpanel" aria-labelledby="yearly-tab">
                                <div class="row">

					@foreach($plans as $plan)

					    <div class="col-lg-3 col-md-6">
						<div class="price_box">
						    <h5 class="price_title">{{$plan->name}}</h5>
						    <div class="price_lists">
							<p><strong>Limite de palabras:</strong> {{$plan->word_limit}}</p>
							<p><strong>Resumenes:</strong> {{$plan->summaries}}</p>
							<p><strong>Nº Test:</strong> {{$plan->test_questions_count}}</p>
							<p><strong>Nº Editores:</strong> {{$plan->editors_count}}</p>
							<p><strong>Nº Mapas conceptuales:</strong> {{$plan->concept_map}}</p>
							@if ($plan->voiceover > 0)
								<p><strong>Locución en línea:</strong> {{$plan->voiceover}}</p>
						        @endif
						    </div>

							@if(isset($plan->is_client_plan) && $plan->is_client_plan)
								<a href="/unsubscribe/{{$plan->id}}" class="buttonRed w-100">Darse de baja</a>
							@else
								<a href="/buy/{{$plan->stripe_annual_price_id}}" class="button w-100">{{$plan->annual_price}}€ / año</a>
						    	@endif
						</div>
					    </div>

					@endforeach

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
