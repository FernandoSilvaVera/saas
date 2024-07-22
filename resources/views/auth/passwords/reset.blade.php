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


	<style>

		body{
			background-color: white;
		}
	

	</style>

    </head>

<div class="container">





	<div id="register_modal" tabindex="-1" role="dialog" aria-labelledby="register_modalTitle"
	    aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		    <button type="button" class="modal_close" data-dismiss="modal" aria-label="Close">
			<img src="./img/cross.svg" alt="">
		    </button>
		    <div class="modal-body">
			<div class="modal_content">
			    <a href="#" class="logo x_center">
				<img src="/img/logo.svg" alt="">
			    </a>
			    <h2 class="pt_24 pb_24 text-center">Recuperar Contraseña</h2>

			 <form method="POST" action="{{ route('password.recover') }}">
			 @csrf
			<input type="hidden" name="token" value="{{ $token }}">


				<div class="form_group w-100 account_info_form_group align-items-end">
				    <div class="form_inner_wrap">
					<label for="Password" class="d-flex pb_10">Email</label>
					<div class="show_hide_warp position-relative">
						 <input id="email" type="email" class="input_field w-100" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
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
				</div>

				<div class="form_group w-100 account_info_form_group align-items-end">
				    <div class="form_inner_wrap">
					<label for="Password" class="d-flex pb_10">Contraseña</label>
					<div class="show_hide_warp position-relative">
						 <input id="password" type="password" class="input_field w-100" class="" name="password" required autocomplete="new-password">
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
				</div>
				<div class="form_group w-100 account_info_form_group align-items-end">
				    <div class="form_inner_wrap">
					<label for="Password" class="d-flex pb_10">Repetir Contraseña</label>
					<div class="show_hide_warp position-relative">
						 <input id="password-confirm" type="password" class="input_field w-100" name="password_confirmation" required autocomplete="new-password">
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
				</div>

			    <button type="submit" class="button w-100 mt-5">Restablecer Contraseña</button>

			    @error('email')
				    <div class="alert alert-danger mt-5 text-center">Ha ocurrido un error</div>
			    @enderror

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
