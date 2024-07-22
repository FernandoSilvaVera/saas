<div class="modal fade" id="recover_modal" tabindex="-1" role="dialog" aria-labelledby="register_modalTitle"
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
		    <h2 class="pt_24 pb_24 text-center">RECUPERAR CONTRASEÑA</h2>

		 <form method="POST" action="{{ route('password.email') }}">
		 @csrf
			<div class="form_group pb_24 w-100">
			    <label for="Email" class="d-flex pb_10">Correo</label>
			    <div class="show_hide_warp position-relative">
				 <input type="email" class="input_field w-100" id="email" name="email" value="{{ old('email') }}" required autofocus>

			    </div>
			</div>


		    <button type="submit" class="button w-100">Recuperar contraseña</button>

		    <p onclick="login()" class="text_xsm pt_24 text-center">¿Ya tienes una cuenta? <a href="#">Iniciar Sesión</a>
		    </p>
		</div>

		</form>

	    </div>
	</div>
    </div>
</div>
