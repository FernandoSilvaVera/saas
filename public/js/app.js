function getLanguage()
{
	return $('#language').val();
}

function getTemplate()
{
	return $('#template').val();
}

function getSummaryOption() {
	return $('#summaryOptions').val();
}

function isGenerateQuestionsChecked() {
	return $('#generateQuestions').is(':checked');
}

function isGenerateConceptMapChecked() {
	return $('#generateConceptMap').is(':checked');
}

function isUseNaturalVoiceChecked() {
	return $('#useNaturalVoice').is(':checked');
}

function previewDocument(){
	document.getElementById("templateId").value = getTemplate()
	document.getElementById("languageInput").value = getLanguage()

	$('#summaryOptionPreview').val(getSummaryOption());
	$('#generateQuestionsPreview').val(isGenerateQuestionsChecked() ? '1' : '0');
	$('#generateConceptMapPreview').val(isGenerateConceptMapChecked() ? '1' : '0');
	$('#useNaturalVoicePreview').val(isUseNaturalVoiceChecked() ? '1' : '0');

	var formulario = document.getElementById("formularioSubir");
	formulario.submit();
}

function downloadButton(){
	document.getElementById("templateIdDownload").value = getTemplate()
	document.getElementById("languageInputDownload").value = getLanguage()

	$('#summaryOptionDownload').val(getSummaryOption());
	$('#generateQuestionsDownload').val(isGenerateQuestionsChecked() ? '1' : '0');
	$('#generateConceptMapDownload').val(isGenerateConceptMapChecked() ? '1' : '0');
	$('#useNaturalVoiceDownload').val(isUseNaturalVoiceChecked() ? '1' : '0');
	var formulario = document.getElementById("download");

	formulario.submit();
}

document.getElementById("subirFichero").addEventListener("click", function(event) {
	event.preventDefault(); // Prevenir la acción por defecto del enlace
	document.getElementById("archivoInput").click();
});
