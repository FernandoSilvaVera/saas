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
                    <h1>Templates</h1>
                </div>

                <div class="header_right d-flex gap_24 align-items-center">
                    <a href="#">
                        <img src="./img/notification.svg" class="w_24" alt="">
                    </a>
                    <a href="#" class="">
                        <img src="./img/setting.svg" class="w_24" alt="">
                    </a>
                    <a href="#">
                        <img src="./img/header_img.png" class="header_img" alt="">
                    </a>
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
                                    <div class="contact_top pb_20">
                                        <h2>Canceled Subscribed</h2>
                                    </div>

                                    <div class="preview_template_content">
                                        <div id="topBackgroundTemplate"
                                            class="preview_template_top d-flex align-items-center justify-content-between">
                                            <img src="./img/preview_template_left.svg" class="preview_template_top_left"
                                                alt="">

                                            <div class="preview_template_top_right d-flex align-items-center">
                                                

					    <a href="#" class="iconsTop">
						    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
							    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
						    </svg>
					    </a>

					    <a href="#" class="iconsTop">
						    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
							    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
						    </svg>
					    </a>


					    <a href="#" class="iconsTop">
						    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
							    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
						    </svg>

					    </a>



                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div id="rightBackgroundTemplate" class="preview_template_left preview_template_main">
                                                    <img id="previewImage" src="./img/preview_image.png" alt="">
                                                    <div class="text_box pb_15">
                                                        <p class="text_sm">1. Teorías del juego: causales,
                                                            finales y
                                                            estructurales</p>
                                                    </div>
                                                    <div class="text_box pb_15">
                                                        <p class="text_sm">1.1 Teorías causales del juego</p>
                                                        <p class="text_sm">1.2 Teorías finales del juego</p>
                                                        <p class="text_sm">1.3 Teorías estructurale</p>
                                                    </div>
                                                    <div class="text_box pb_15">
                                                        <p class="text_sm">2. Evolución del juego en el ciclo
                                                            vital
                                                            humano</p>
                                                    </div>
                                                    <div class="text_box pb_15">
                                                        <p class="text_sm">3.Antropología del juego</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div id="leftBackgroundTemplate" class="preview_template_right preview_template_main">
                                                    <h2>Conceptos generales</h2>

                                                    <div class="text_box pb_15">
                                                        <p class="text_sm">El concepto de juego es más o menos
                                                            fácil de
                                                            entender en el uso cotidiano dentro de los distintos
                                                            ámbitos
                                                            que abarca. Pero a su vez, esa misma diversidad de
                                                            usos hace
                                                            compleja</p>
                                                        <p class="text_sm">la definición desde un punto de vista
                                                            científico-académico.</p>
                                                        <p class="text_sm">El juego se vincula:</p>
                                                        <p class="text_sm">a actividades de destreza, astucia o
                                                            azar, o
                                                            combinaciones de las mismas</p>
                                                        <p class="text_sm">a actividades físicas realizadas sin
                                                            finalidad y sometida a reglas</p>
                                                        <p class="text_sm">a actividades de diversión y
                                                            entretenimiento
                                                            de niños y en menor grado de adultos;</p>
                                                        <p class="text_sm">a actividades relacionadas con el
                                                            mundo del
                                                            arte creativo (poesía, teatro, danza, pintura y
                                                            música).</p>
                                                        <p class="text_sm">Al pertenecer a muy distintos
                                                            ámbitos, el
                                                            concepto de juego implica connotaciones diversas,
                                                            que van
                                                            desde la diversión y entretenimiento, a lo no útil o
                                                            no
                                                            productivo, lo no serio,</p>
                                                        <p class="text_sm">lo realizado con facilidad, ligereza,
                                                            frivolidad o irresponsabilidad, lo estético o
                                                            artístico y
                                                            llega hasta lo erótico/sexual y placentero. |</p>
                                                        <p class="text_sm">En go e i histo diversidad, ace
                                                            disiad
                                                            dentica en el ine ada sitio de enton tela ue orto
                                                            los se
                                                            euro lenin saciane tan 2va) con a le a</p>
                                                        <p class="text_sm">que el juego no es lo opuesto al
                                                            trabajo
                                                            (concepción clásica sobre el juego como actividad no
                                                            seria/no productiva) sino lo opuesto a la depresión,
                                                            debido
                                                            al estado de creatividad y</p>
                                                        <p class="text_sm">vitalidad desarrollado en la
                                                            actividad
                                                            lúdica.</p>
                                                        <p class="text_sm">Han sido muchos los autores que a lo
                                                            largo de
                                                            los últimos dos siglos han tratado de definir la
                                                            actividad
                                                            conocida como juego.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="create_template section_padding_bg">
                                    <div class="form_group">
                                        <label for="FName" class="d-flex pb_10">Template Name</label>
                                        <input type="text" class="input_field w-100"
                                            placeholder="Enter your template name" required="">
                                    </div>
                                    <div class="upload_boxes d-flex align-items-center pt_20">
                                        <div class="upload w-50">
                                            <h4 class="pb_10">Add a logo</h4>
                                            <div id="drop-container" class="drop-container">
                                                <label for="file-input1">
                                                    <div class="upload_img">
                                                        <img class="icon preview-image" src="./img/gallery.png"
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
                                            <h4 class="pb_10">Add a favicon</h4>
                                            <div id="drop-container" class="drop-container">
                                                <label for="file-input2">
                                                    <div class="upload_img">
                                                        <img class="icon preview-image" src="./img/gallery.png"
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
                                            <p class="text_sm">Right background Color</p>
                                            <div class="color_wrap">
                                                <div class="color_inner">
                                                    <input id="rightBackground" type="color" class="color_palate" value="#C7DAE7">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color_box pb_20 d-flex align-items-center justify-content-between">
                                            <p class="text_sm">Left background Color</p>
                                            <div class="color_wrap">
                                                <div class="color_inner">
                                                    <input id="leftBackground" type="color" class="color_palate" value="#8AB5D4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color_box pb_20 d-flex align-items-center justify-content-between">
                                            <p class="text_sm">Top background Color</p>
                                            <div class="color_wrap">
                                                <div class="color_inner">
                                                    <input id="topBackground" type="color" class="color_palate" value="#D5D7D9">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color_box pb_20 d-flex align-items-center justify-content-between">
                                            <p class="text_sm">Buttons on the top right Color</p>
                                            <div class="color_wrap">
                                                <div class="color_inner">
                                                    <input id="topIconsBackground" type="color" class="color_palate" value="#428BCA">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form_groups template_font_styles pb_24 d-flex align-items-center">
                                        <div class="form_group">
                                            <label for="FName" class="d-flex pb_10">Fonts</label>
					    <select class="input_field select_field w-100" name="fontFamily">
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
                                    <button id="saveTemplate" class="button w-100">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>


    <!-- all js here -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/templates.js') }}"></script>


</body>
</html>
