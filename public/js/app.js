function useTemplate(template) {
	$('#rightBackgroundTemplate').css('background-color', template.css_right);
	$('#leftBackgroundTemplate').css('background-color', template.css_left);
	$('#topBackgroundTemplate').css('background-color', template.css_top);
	$('.iconsTop').css('fill', template.css_icons);
	$('#leftBackgroundTemplate p').css('font-family', template.typography);
	$('#leftBackgroundTemplate p').css('font-size', template.font_size + 'px');
}
