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

		    <form action="{{ route('config.update') }}" method="POST" class="contact_form">
			    @csrf

			    <div class="form_groups d-flex gap_24 pb_20 align-items-center">

				    <div class="form_group w-50">
					    <label for="concept_map_percentage">% de palabras en mapa conceptual</label>
					    <input type="number" name="concept_map_percentage" class="input_field w-100" value="{{ $configs['concept_map_percentage']->value ?? '' }}" required>
				    </div>

				    <div class="form_group w-50">
					    <label for="long_summary_percentage">% de palabras en resumen largo</label>
					    <input type="number" name="long_summary_percentage" class="input_field w-100" value="{{ $configs['long_summary_percentage']->value ?? '' }}" required>
				    </div>

				    <div class="form_group w-50">
					    <label for="short_summary_percentage">% de palabras en resumen corto</label>
					    <input type="number" name="short_summary_percentage" class="input_field w-100" value="{{ $configs['short_summary_percentage']->value ?? '' }}" required>
				    </div>
			    </div>

			    <div class="form_groups d-flex gap_24 pb_20 align-items-center">

				    <div class="form_group w-50">
					    <label for="questions_percentage">% de palabras usadas en preguntas</label>
					    <input type="number" name="questions_percentage" class="input_field w-100" value="{{ $configs['questions_percentage']->value ?? '' }}" required>
				    </div>

				    <div class="form_group w-50">
					    <label for="online_narration_percentage">% de palabras usadas en locución en línea</label>
					    <input type="number" name="online_narration_percentage" class="input_field w-100" value="{{ $configs['online_narration_percentage']->value ?? '' }}" required>
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
