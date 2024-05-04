var templateId = null

function useTemplate(template) {
	templateId = template.id
}

function previewDocument(){
	document.getElementById("templateId").value = templateId;
	var formulario = document.getElementById("formularioSubir");
	formulario.submit();
}

function downloadButton(){
	document.getElementById("templateIdDownload").value = templateId;
	var formulario = document.getElementById("download");
	formulario.submit();
}

document.getElementById("subirFichero").addEventListener("click", function(event) {
	event.preventDefault(); // Prevenir la acción por defecto del enlace
	document.getElementById("archivoInput").click();
});
