<div class="modal fade" id="register_modal" tabindex="-1" role="dialog" aria-labelledby="register_modalTitle"
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
		    <h2 class="pt_24 pb_24 text-center">Registro</h2>

		 <form method="POST" action="{{ route('register') }}">
		 @csrf
			<div class="form_group pb_24 w-100">
			    <label for="Email" class="d-flex pb_10">Correo</label>
			    <div class="show_hide_warp position-relative">
				 <input type="email" class="input_field w-100" id="email" name="email" value="{{ old('email') }}" required autofocus>

			    </div>
			</div>
			<div class="form_group w-100 account_info_form_group align-items-end">
			    <div class="form_inner_wrap">
				<label for="Password" class="d-flex pb_10">Contraseña</label>
				<div class="show_hide_warp position-relative">

					 <input type="password" class="input_field w-100" id="password" name="password" required autocomplete="current-password">
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

					 <input type="password" class="input_field w-100" id="password_confirmation" name="password_confirmation" required autocomplete="current-password">
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

		    <div class="check_box active pt_24 pb_24 d-flex align-items-center ">
			<div class="check">
			    <img src="./img/check_mark.svg" alt="">
			</div>
			<p class="text_sm pl_10">Recuerdame</p>
		    </div>

		    <button type="submit" class="button w-100">Registrarse</button>

		    <p onclick="login()" class="text_xsm pt_24 text-center">¿Ya tienes una cuenta? <a href="#">Iniciar Sesión</a>
		    </p>
		</div>

	    </form>

	    </div>
	</div>
    </div>
</div>
