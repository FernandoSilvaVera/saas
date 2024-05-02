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

});
