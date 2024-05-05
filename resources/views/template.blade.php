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

                <!-- Template Section -->
                <section class="template_section">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="preview_template section_padding_bg">

					@include('includes/template')

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="create_template section_padding_bg">
                                    <div class="form_group">
                                        <label for="FName" class="d-flex pb_10">Nombre de plantilla</label>
                                        <input id="templateName" type="text" class="input_field w-100"
                                            placeholder="Enter your template name" required="" value="{{$template->template_name}}">
                                    </div>
                                    <div class="upload_boxes d-flex align-items-center pt_20">
                                        <div class="upload w-50">
                                            <h4 class="pb_10">Logo</h4>
                                            <div id="drop-container" class="drop-container">
                                                <label for="file-input1">
                                                    <div class="upload_img">
                                                        <img id="logoImg" class="icon preview-image" src="{{$template->logo_path}}"
                                                            alt="Icon" onclick="handleImageClick(event)" />
                                                        <button class="cross" onclick="removeImage()">
                                                            <img src="./img/cross.svg" alt="" />
                                                        </button>
                                                    </div>
                                                    <a class="redirect_btn upload-btn" onclick="uploadImage()">
                                                        <img src="./img/filled_circled.svg" alt="">
                                                    </a>
                                                </label>
                                                <input type="file" id="file-input1" style="display: none"
                                                    onchange="handleFileSelect(this)" />
                                            </div>
                                        </div>
                                        <div class="upload w-50">
                                            <h4 class="pb_10">Favicon</h4>
                                            <div id="drop-container" class="drop-container">
                                                <label for="file-input2">
                                                    <div class="upload_img">
                                                        <img id="faviconImg" class="icon preview-image" src="{{$template->favicon_path}}"
                                                            alt="Icon" onclick="handleImageClick(event)" />
                                                        <button class="cross" onclick="removeImage()">
                                                            <img src="./img/cross.svg" alt="" />
                                                        </button>
                                                    </div>
                                                    <a class="upload-btn" class="redirect_btn" onclick="uploadImage()">
                                                        <img src="./img/filled_circled.svg" alt="">
                                                    </a>
                                                </label>
                                                <input type="file" id="file-input2" style="display: none"
                                                    onchange="handleFileSelect(this)" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="color_boxes pb_20 pt_20">
                                        <div class="color_box pb_20 d-flex align-items-center justify-content-between">
                                            <p class="text_sm">Derecha</p>
                                            <div class="color_wrap">
                                                <div class="color_inner">
                                                    <input id="rightBackground" type="color" class="color_palate" value="{{$template->css_right}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color_box pb_20 d-flex align-items-center justify-content-between">
                                            <p class="text_sm">Izquierda</p>
                                            <div class="color_wrap">
                                                <div class="color_inner">
                                                    <input id="leftBackground" type="color" class="color_palate" value="{{$template->css_left}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color_box pb_20 d-flex align-items-center justify-content-between">
                                            <p class="text_sm">Arriba</p>
                                            <div class="color_wrap">
                                                <div class="color_inner">
                                                    <input id="topBackground" type="color" class="color_palate" value="{{$template->css_top}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color_box pb_20 d-flex align-items-center justify-content-between">
                                            <p class="text_sm">Iconos superiores</p>
                                            <div class="color_wrap">
                                                <div class="color_inner">
                                                    <input id="topIconsBackground" type="color" class="color_palate" value="{{$template->css_icons}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form_groups template_font_styles pb_24 d-flex align-items-center">
                                        <div class="form_group">
                                            <label for="FName" class="d-flex pb_10">Fuentes</label>
					    <select id="fontFamily" class="input_field select_field w-100" name="fontFamily">
						    <option value="Poppins" selected>Poppins</option>
						    <option value="Lato">Lato</option>
						    <option value="Montserrat">Montserrat</option>
						    <option value="Open Sans">Open Sans</option>
						    <option value="Roboto">Roboto</option>
						    <option value="Arial">Arial</option>
						    <option value="Helvetica">Helvetica</option>
						    <option value="Georgia">Georgia</option>
					    </select>
                                        </div>
                                        <div class="form_group">
                                            <label for="FName" class="d-flex pb_10">Letras</label>

					    <select id="fontSize" class="input_field select_field w-100" name="fontSize">
						    <option value="20">20</option>
						    <option value="24" selected>24</option>
						    <option value="28">28</option>
						    <option value="32">32</option>
					    </select>
                                        </div>
                                    </div>
                                    <button id="saveTemplate" class="button w-100">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

	<script>
		var templateNew = "{{ route('template.new') }}";
		var csrfToken = "{{ csrf_token() }}";
		var templateId = "{{$template->id}}"
	</script>

    <!-- all js here -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/templates.js') }}"></script>


</body>
</html>
