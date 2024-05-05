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


    @auth



    @else


 <form method="POST" action="{{ route('login') }}">
         @csrf

	         <div>
		             <label for="email">Email</label>
			                 <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
					         </div>

						         <div>
							             <label for="password">Contraseña</label>
								                 <input type="password" id="password" name="password" required autocomplete="current-password">
										         </div>

											         <div>
												             <input type="checkbox" id="remember" name="remember">
													                 <label for="remember">Recuérdame</label>
															         </div>

																         <button type="submit">Iniciar sesión</button>
																	     </form>


    @endauth






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

                <!-- contact_section -->
                <div class="contact_section section_padding_bg">
                    <div class="container-fluid">
                        <div class="contact_top pb_24">
                            <h2 class="pb_10">Choose Your Plans</h2>
                            <p>You will bw charged for the plan after the admin approves your vendor
                                account</p>
                        </div>

                        <form action="#" class="contact_form">
                            <div class="form_groups d-flex gap_24 pb_20 align-items-center">
                                <div class="form_group w-50">
                                    <label for="FName" class="d-flex pb_10">First Name</label>
                                    <input type="text" class="input_field w-100" placeholder="Type here" required>
                                </div>
                                <div class="form_group w-50">
                                    <label for="LName" class="d-flex pb_10">Last Name</label>
                                    <input type="text" class="input_field w-100" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="form_groups d-flex gap_24 pb_20 align-items-center">
                                <div class="form_group w-50">
                                    <label for="Email" class="d-flex pb_10">Email Address</label>
                                    <input type="text" class="input_field w-100" placeholder="Type here" required>
                                </div>
                                <div class="form_group w-50">
                                    <label for="Mobile" class="d-flex pb_10">Mobile</label>
                                    <input type="text" class="input_field w-100" placeholder="Type here" required>
                                </div>
                            </div>
                            <div class="form_groups d-flex gap_24 pb_20 align-items-center">
                                <div class="form_group w-50">
                                    <label for="FName" class="d-flex pb_10">Country</label>
                                    <select class="input_field select_field w-100" name="Country">
                                        <option value="Select" selected>Select</option>
                                        <option value="option 1">option 1</option>
                                        <option value="option 2">option 2</option>
                                        <option value="option 3">option 3</option>
                                    </select>
                                </div>
                                <div class="form_group w-50">
                                    <label for="FName" class="d-flex pb_10">Job Title</label>
                                    <input type="text" class="input_field w-100" placeholder="Type here" required>
                                </div>
                            </div>
                            <div class="form_group w-100 pb_20">
                                <label for="FName" class="d-flex pb_10">Message</label>
                                <textarea name="message" class="w-100" placeholder="Type here"></textarea>
                            </div>
                            <div class="form_group d-flex justify-content-end">
                                <button type="submit" class="button">Submit</button>
                            </div>
                        </form>

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
