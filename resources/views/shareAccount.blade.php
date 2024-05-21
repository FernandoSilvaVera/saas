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

		@include('includes/message')

                <!-- Create user Section -->

                <div class="create_user_page">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="Create_user section_padding_bg">
                                    <div class="container-fluid">

                                            <div class="form_groups d-flex gap_24 pb_20 align-items-center">
                                                <div class="form_group w-100">
                                                    <label for="planName" class="d-flex pb_10">Correo Principal</label>
                                                    <input id="planName" type="text" class="input_field w-100" placeholder="" value="{{$email}}"
                                                        required>
                                                </div>
                                            </div>

					    <form id="updateForm" action="/updateShareAccount" method="POST">
						    @csrf 

						@foreach ($editores as $editor)
							<div class="form_groups d-flex gap_24 pb_20 align-items-center">
							<div class="form_group w-100">
							<label for="editor{{$loop->index + 1}}" class="d-flex pb_10">Correo Compartido {{$loop->index + 1}}</label>
							<input name="editores[]" id="editor{{$loop->index + 1}}" type="text" class="input_field w-100" placeholder="Correo Compartido {{$loop->index + 1}}"
							value="{{$editor}}" required>
							</div>
							</div>
						@endforeach

						<div class="form_group d-flex justify-content-end">
						<button type="button" onclick="update()" class="button">Actualizar</button>
						</div>

						<input type="hidden" id="editoresArray" name="editoresArray">
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
    <script src="{{ asset('js/shareAccount.js') }}"></script>



</body>
</html>
