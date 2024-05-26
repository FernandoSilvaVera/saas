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

		@if(session('success'))
			<div class="alert alert-success">
				{{ session('success') }}
			</div>
		@endif

		@if($errors->any())
			<div class="alert alert-danger">
				<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
				</ul>
			</div>
		@endif

                <!-- contact_section -->
                <div class="contact_section section_padding_bg">
                    <div class="container-fluid">

		    <form action="{{ route('password.update') }}" method="POST" class="contact_form">
			    @csrf
			    @method('PUT')
			    <div class="form_groups d-flex gap_24 pb_20 align-items-center">
				    <div class="form_group w-100">
					    <label for="email" class="d-flex pb_10">Email</label>
					    <input type="text" class="input_field w-100" placeholder="Email" readonly value="{{ $user->email }}">
				    </div>
			    </div>

			    <div class="form_groups d-flex gap_24 pb_20 align-items-center">

				    <div class="form_group w-50">
					    <label for="current_password" class="d-flex pb_10">Contraseña Actual</label>
					    <input id="current_password" name="current_password" type="password" class="input_field w-100" placeholder="Actual" required>
				    </div>

				    <div class="form_group w-50">
					    <label for="new_password" class="d-flex pb_10">Nueva Contraseña</label>
					    <input id="new_password" name="new_password" type="password" class="input_field w-100" placeholder="Nueva" required>
				    </div>

				    <div class="form_group w-50">
					    <label for="new_password_confirmation" class="d-flex pb_10">Repetir Contraseña</label>
					    <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="input_field w-100" placeholder="Repetir" required>
				    </div>

			    </div>

			    <div class="form_group d-flex justify-content-end">
				    <button type="submit" class="button">Actualizar</button>
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
