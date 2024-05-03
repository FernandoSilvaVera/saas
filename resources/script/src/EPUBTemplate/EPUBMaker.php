<?php

namespace EPUBTemplate;

class EPUBMaker {

	public function getEpubName($skelEPUB)
	{
		return $skelEPUB . "tmp/download.epub";
	}

	public function createEPUB($skelEPUB){
		$mimetype = "mimetype";
		$epubFOLDER = "META-INF EPUB";
		$epubNAME = "download.epub";

		// Cambia el directorio de trabajo a tmp
		chdir($skelEPUB . "tmp/");

		// Ejecuta los comandos zip
		exec("zip -X -0 $epubNAME $mimetype");
		exec("zip -rX9D $epubNAME $epubFOLDER");
	}

	public function moveEPUB($skelEPUB, $outputPath)
	{
		$epub = "download.epub";
		rename($epub, $outputPath . $epub);
	}

}

?>
