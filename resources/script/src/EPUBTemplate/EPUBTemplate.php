<?php

namespace EPUBTemplate;

use HTMLExporter\HTMLExporter;
use EPUBTemplate\ContentOPF;

class EPUBTemplate {

	private $htmlExporter = "";
	private $html = "";
	private $contentOPF = null;
	private $tocNCX = null;

	public function __construct($htmlExporter) {
		$this->htmlExporter = $htmlExporter;
		$this->contentOPF = new ContentOPF;
		$this->tocNCX = new TocNCX;
		$this->epubMAKER = new EPUBMaker;
	}

	public function loadTemplate($templatePath) {
		$this->html = file_get_contents($templatePath . "skel.xhtml");
	}

	public function loadTemplateNav($templatePath){
		$this->html = file_get_contents($templatePath . "skelNav.xhtml");
	}

	public function saveHTMLFile($skelEPUBPATH, $name){
		$this->htmlExporter->saveHTMLFileEPUB($skelEPUBPATH, $this->html, $name);
	}

	public function saveImages($skelEPUBPATH, $imagesPath){
		$this->htmlExporter->saveImagesEPUB($skelEPUBPATH, $imagesPath);
	}

	public function insertContent($content, $title){
		$this->html = str_replace("{contentHTML}", $content, $this->html);
		$this->html = str_replace("{title}", $title, $this->html);
		$this->html = str_replace("imagenes/", "../", $this->html);
	}

	public function moveEPUB($skelEPUB, $outputPath)
	{
		$this->epubMAKER->moveEPUB($skelEPUB, $outputPath);
	}

	public function convertToEPUB($imagesPath, $skelEPUBPATH, $wordContent, $wordTitles)
	{
		$this->htmlExporter->copyLibrariesEPUB($skelEPUBPATH);

		$pages = [];

		$nameHTML = "ch00";
		$pos = 1;


		foreach($wordContent as $contentLVL1 => $lvl1){
			$html = "";

			$this->addHX($html, 1, $contentLVL1);

			foreach($lvl1 as $contentLVL2 => $lvl2){
				if($contentLVL2 == "html"){
					$html .= $lvl2;
				}
				if(is_array($lvl2)){

					$this->addHX($html, 2, $contentLVL2);

					foreach($lvl2 as $contentLVL3 => $lvl3){
						if($contentLVL3 == "html"){
							$html .= $lvl3;
						}else{
							$this->addHX($html, 3, $contentLVL3);
							$html .= $lvl3;
						}
					}
					$html .= '</div>';
				}
				$html .= '</div>';
			}
			$this->loadTemplate($skelEPUBPATH);
			$this->insertContent($html, $contentLVL1);

			$fileName = $nameHTML . $pos++;

			//text
			$this->saveHTMLFile($skelEPUBPATH, $fileName);
			$this->pages[] = $fileName;

		}

		//media
		$this->saveImages($skelEPUBPATH, $imagesPath);

		//content.opf
		$this->contentOPF->setPages($this->pages);
		$this->contentOPF->setImages($imagesPath);
		$this->contentOPF->createOPF($skelEPUBPATH, $wordTitles);

		//nav.x.html
		$this->loadTemplate($skelEPUBPATH);
		$this->createNAV_X_HTML($wordTitles, $skelEPUBPATH);

		//toc.ncx
		$this->tocNCX->createTOC_NCX($skelEPUBPATH, $wordTitles);

		//download.EPUB
		$this->epubMAKER->createEPUB($skelEPUBPATH);
	}

	private function addHX(&$html, $H, $title){
		$HX = $this->convertHXToID($title);
		$html .= '<div id="' . $HX . '" class="section level' . $H . '">';
		$html .= "<h$H>" . $title . "</h$H>";
	}

	private function convertHXToID($HX){
		return preg_replace('/[^a-zA-Z0-9]+/', '-', $HX);
	}

	private function createNAV_X_HTML($titles, $outputHtmlPath) {

		$outputHtmlPath .= "tmp/EPUB/nav.x.html";

		$html = "<div id=\"toc\"><h1 id=\"toc-title\">ud1_practicas_iniciacion_prof_curso2</h1><ol class=\"toc\">";
		$destino = 1;

		$nameHTML = "ch00";
		// Nivel 1
		foreach ($titles as $nivel1 => $subniveles1) {

			$href = "text/$nameHTML$destino.x.html";

			$html .= "<li><a href='$href'>$nivel1</a></li>";
			$html .= "<ol>";

			// Nivel 2
			foreach ($subniveles1 as $nivel2 => $subniveles2) {

				$id = $this->convertHXToID($nivel2);

				$html .= "<li><a href='$href#{$id}'>$nivel2</a></li>";
				$html .= "<ol>";

				// Nivel 3
				foreach ($subniveles2 as $nivel3 => $contenido) {
					$id = $this->convertHXToID($nivel3);
					$html .= "<li><a href='$href#{$id}'>$nivel3</a></li>";
				}

				$html .= "</ol>";
			}

			$html .= "</ol>";
			$destino++;
		}

		$html .= "</ol></div>";

		// Guardar el HTML del índice
		$this->html = str_replace("{contentHTML}", $html, $this->html);
		file_put_contents($outputHtmlPath, $this->html);
	}

}

?>
