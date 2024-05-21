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

                <!-- App_section -->
                <section class="app_section section_padding_bg">
                    <div class="container-fluid">
                        <div class="app_top pb_24 d-flex align-items-center justify-content-between">
                            <div class="select app_top_select">

                                <div class="selected_tab">
					@if(!isset($template))
					    <p class="text_sm selected_text">Selecciona una plantilla</p>
					@endif

					@if(isset($template))
					    <p class="text_sm selected_text">{{$template->template_name}}</p>
					@endif

                                    <!-- arrow_down_app -->
                                    <div class="arrow_down_app">
                                        <img src="./img/arrow_down_app.svg" alt="">
                                    </div>
                                </div>


                                <div class="select_tab_dropdown" id="myTab" role="tablist">
					@foreach($templates as $templateList)
						<button onclick="useTemplate({{$templateList}})" id="{{$templateList->id}}" class="select_tab">{{ $templateList->template_name }}</button>
					@endforeach
                                </div>


                            </div>

			    @if(session('success'))
			    <div class="alert alert-success">
{{ session('success') }}
</div>
@endif

                            <div class="apptop_right d-flex">
				<form id="formularioSubir" action="{{ route('preview-document') }}" method="POST" enctype="multipart/form-data">
					@CSRF
					<input type="hidden" id="templateId" name="templateId" value="">
					<input type="file" id="archivoInput" name="fileName" style="display: none;">
					@if(isset($filePath))
						<input type="hidden" id="archivoInputPrev" name="filePath" value="{{$filePath}}">
					@endif
					<a href="#" id="subirFichero" class="button button_trasparent mr_20">Subir Fichero</a>
				</form>
				<a onclick="previewDocument()" class="button button_trasparent mr_20" style="cursor: pointer">Preview</a>
				@if(isset($showDownload))
				<form id="download" action="{{ route('download') }}" method="POST" enctype="multipart/form-data">

					@CSRF
					<input type="hidden" id="templateIdDownload" name="templateId" value="">
					@if(isset($filePath))
						<input type="hidden" name="filePath" value="{{$filePath}}">
					@endif
				</form>
				<a onclick="downloadButton()" id="downloadFile" class="button button_trasparent mr_20">Descargar</a>

				@endif
                            </div>
                        </div>

                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-lg-3">
                                <div class="section_padding_bg">
					@include('includes/remaining', ['bloquearCampos' => true])
                                </div>
                            </div>

                            <div class="col-lg-9">
				<div id="preview">
					@if(isset($preview))
						<iframe id="miIframe" src="{{$preview}}" frameborder="0" style="width:100%; height:800px;"></iframe>
					@endif
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
    <script src="{{ asset('js/app.js') }}"></script>


	@if(isset($template))
		<script>
			templateId = {{$template->id}}
		</script>
	@endif
	

</body>
</html>
