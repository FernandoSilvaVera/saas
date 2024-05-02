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

                <!-- App_section -->
                <section class="app_section section_padding_bg">
                    <div class="container-fluid">
                        <div class="app_top pb_24 d-flex align-items-center justify-content-between">
                            <div class="select app_top_select">

                                <div class="selected_tab">
                                    <p class="text_sm selected_text">Templates</p>
                                    <!-- arrow_down_app -->
                                    <div class="arrow_down_app">
                                        <img src="./img/arrow_down_app.svg" alt="">
                                    </div>
                                </div>


                                <div class="select_tab_dropdown" id="myTab" role="tablist">
                                    <button class="active select_tab">Templates</button>
                                    <button class="select_tab">History</button>
                                    <button class="select_tab">Details</button>
                                    <button class="select_tab">Data</button>
                                </div>


                            </div>

                            <div class="apptop_right d-flex">
                                <a href="#" class="button button_trasparent mr_20">Upload Files</a>
                                <a href="#" class="button button_trasparent">Upload Files</a>
                            </div>
                        </div>


                                <div class="preview_template section_padding_bg">

                                    <div class="preview_template_content">
                                        <div
                                            class="preview_template_top d-flex align-items-center justify-content-between">
                                            <img src="./img/preview_template_left.svg" class="preview_template_top_left"
                                                alt="">

                                            <div class="preview_template_top_right d-flex align-items-center">
                                                <a href="#">
                                                    <img src="./img/cart-fill.svg" alt="">
                                                </a>
                                                <a href="#">
                                                    <img src="./img/heart-fill.svg" alt="">
                                                </a>
                                                <a href="#">
                                                    <img src="./img/user icon.svg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="preview_template_left preview_template_main">
                                                    <img src="./img/preview_image.png" alt="">
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
                                                <div class="preview_template_right preview_template_main">
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
                </section>

            </div>
        </div>
    </div>


    <!-- all js here -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
