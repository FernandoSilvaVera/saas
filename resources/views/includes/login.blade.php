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

		 <form method="POST" action="{{ route('login') }}">
		 @csrf
			<div class="form_group pb_24 w-100">
			    <label for="Email" class="d-flex pb_10">Type here</label>
			    <div class="show_hide_warp position-relative">
				 <input type="email" class="input_field w-100" id="email" name="email" value="{{ old('email') }}" required autofocus>
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
				<p class="text_xsm pt_10">At least 8 characters and one number.</p>
			    </div>
			</div>

		    <div class="check_box active pt_24 pb_24 d-flex align-items-center ">
			<div class="check">
			    <img src="./img/check_mark.svg" alt="">
			</div>
			<p class="text_sm pl_10">Remember me</p>
		    </div>

		    <button type="submit" class="button w-100">Iniciar Sesión</button>

		    <p class="text_xsm pt_24 text-center">Don’t have an account? <a href="#">Sign up</a>
		    </p>
		</div>

	    </form>

	    </div>
	</div>
    </div>
</div>
