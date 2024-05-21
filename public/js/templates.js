$(document).ready(function() {
	$('#rightBackground').on('input', function() {
		var nuevoColor = $(this).val();
		$('#rightBackgroundTemplate').css('background-color', nuevoColor);
	});
	$('#leftBackground').on('input', function() {
		var nuevoColor = $(this).val();
		$('#leftBackgroundTemplate').css('background-color', nuevoColor);
	});
	$('#topBackground').on('input', function() {
		var nuevoColor = $(this).val();
		$('#topBackgroundTemplate').css('background-color', nuevoColor);
	});
	$('#topIconsBackground').on('input', function() {
		var nuevoColor = $(this).val();
		$('.iconsTop').css('fill', nuevoColor);
	});
	$('#fontFamily').on('input', function() {
		var fontFamily = $(this).val();
		$('#leftBackgroundTemplate p').css('font-family', 'Arial, sans-serif');
	});
	$('#fontSize').on('change', function() {
		var fontSize = $(this).val();
		$('#leftBackgroundTemplate p').css('font-size', fontSize + 'px');
	});

	$('#file-input1').on('change', function(event) {
		var input = event.target;
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
				$('#previewImage').attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	});

	$('#saveTemplate').click(function() {

		var faviconImg = document.getElementById("faviconImg").getAttribute("src");
		var logoImg = document.getElementById("logoImg").getAttribute("src");

		var jsonData = {};
		jsonData.logo_path = logoImg;
		jsonData.favicon_path = faviconImg;
		jsonData.template_name = $('#templateName').val();
		jsonData.css_left = $('#leftBackground').val();
		jsonData.css_right = $('#rightBackground').val();
		jsonData.css_top = $('#topBackground').val();
		jsonData.css_icons = $('#topIconsBackground').val();
		jsonData.typography = $('#fontFamily').val();
		jsonData.font_size = $('#fontSize').val();
		jsonData._token = csrfToken;
		jsonData.templateId = templateId;



		$.ajax({
			url: templateNew,
			type: 'POST',
			contentType: 'application/json',
			data: JSON.stringify(jsonData),
			success: function(response) {
				if (response) {
					window.location.href = "/templatesOk";
				} else {
					var mensajeError = '<div class="alert alert-danger" role="alert">';
					mensajeError += '<strong>Error:</strong> Hubo un problema al guardar la plantilla.';
					mensajeError += '</div>';
					$('#mensaje-container').html(mensajeError);

					setTimeout(function() {
						$('#mensaje-container').empty();
					}, 3000);
				}
			},
			error: function(xhr, status, error) {

			}
		});
	});

});
