<?php

namespace App;

use PhpOffice\PhpWord\IOFactory;

class WordHelper
{

	public $defaultOutputPATH = "";
	public $word = "";
	public $imagesPath = [];

	public $index = [];

	public $idRespuetas = 0;
	public $idPaginador = 1;

	private function isTitle($title, $style, $linea)
	{
		switch ($title) {
			case 1:
				return $style == "Ttulo1";
				break;
			case 2:
				return $style == "Ttulo2";
				break;
			case 3:
				return $style == "Ttulo3";
				break;
		}

		switch ($title) {
			case 1:
				return preg_match('/^(MP \d+|\d+)\. /', $linea, $matches);
				break;
			case 2:
				return preg_match('/^(\d+\.\d+)\. /', $linea, $matches);
				break;
			case 3:
				return preg_match('/^(\d+\.\d+\.\d+)\. /', $linea, $matches);
				break;
		}
		return false;
	}

	public function convertToArray($filePath) {

		$phpWord = IOFactory::load($filePath);

		$estructura = [];

		foreach ($phpWord->getSections() as $section) {
			foreach ($section->getElements() as $element) {
				if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
					$fullText = $element->getText();
					$paragraphStyle = $element->getParagraphStyle();
					$style = $paragraphStyle->getStyleName();

					$lineas = explode("\n", $fullText);

					$saved = false;
					$isTest = false;

					foreach ($lineas as $linea) {


						if ($this->isTitle(1, $style, $linea)) {
							// Nivel principal (MP 1, 1., 2., etc.)
							$nivelActual[0] = $fullText;
							$estructura[$nivelActual[0]] = [];
							$estructura[$nivelActual[0]]["html"] = "";

						} elseif ($this->isTitle(2, $style, $linea)) {
							// Subnivel (1.1., 1.2., etc.)
							$nivelActual[1] = $fullText;
							$estructura[$nivelActual[0]][$nivelActual[1]] = [];
							$estructura[$nivelActual[0]][$nivelActual[1]]["html"] = "";

						} elseif ($this->isTitle(3, $style, $linea)) {
							// Sub-subnivel (1.2.1., 1.2.2., etc.)
							$nivelActual[2] = $fullText;
							$estructura[$nivelActual[0]][$nivelActual[1]][$nivelActual[2]] = "";
						}else{


							$isTest = $this->checkIfTest($fullText);

							$isCustomPager = $this->checkIfCustomPager($fullText);

							if(!$isTest && !$isCustomPager){
								$this->addStyle($fullText, $element, $style);
							}else{
								continue;
							}


							
							if(isset($nivelActual)){
								if (isset($nivelActual[2]) && isset($estructura[$nivelActual[0]]) && 
										isset($estructura[$nivelActual[0]][$nivelActual[1]]) && 
										isset($estructura[$nivelActual[0]][$nivelActual[1]][$nivelActual[2]])) {
									//lvl3
									$estructura[$nivelActual[0]][$nivelActual[1]][$nivelActual[2]] .= $fullText;

								}else if (isset($nivelActual[1]) && isset($estructura[$nivelActual[0]][$nivelActual[1]])){
									//lvl2
									$estructura[$nivelActual[0]][$nivelActual[1]]["html"] .= $fullText;
								}else if (isset($nivelActual[0]) && isset($estructura[$nivelActual[0]])) {
									//lvl1
									$estructura[$nivelActual[0]]["html"] .= $fullText;
								}
							}
						}
					}



				} elseif ($element instanceof \PhpOffice\PhpWord\Element\Image) {

				} elseif ($element instanceof \PhpOffice\PhpWord\Element\TextBreak) {

				} elseif ($element instanceof \PhpOffice\PhpWord\Element\PageBreak) {

				} elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {

					$html = '<table>';

					foreach($element->getRows() as $rowKey => $row){

						$html .= '<tr>';

						$onlyOneColumn = 0;

						foreach($row->getCells() as $cellKey => $cells){

							$onlyOneColumn++;

							foreach($cells->getElements() as $cellElement){
								if ($cellElement instanceof \PhpOffice\PhpWord\Element\TextRun) {
									$textCell = $cellElement->getText();
								}

							}

						}
					}

				}else{

				}
			}

		}

		return $estructura;
	}
	public function checkIfTest(&$fullText)
	{
		// Utilizamos expresiones regulares para extraer el contenido entre las etiquetas "<pregunta>"
		preg_match('/pregunta&gt;([^&]+)&lt;pregunta/', $fullText, $matches);

		$idRespuetas = $this->idRespuetas++;

		// Si encuentra la etiqueta <pregunta>, actualiza el texto completo y la variable $fullText
		if(isset($matches[1])) {
			$fullText = "<script>
				window.addEventListener('load', function() {
					cargarBotonPaginaTest();
				});
				</script>";
			$fullText .= "<h4>" . $matches[1] . "</h4><br>";
			return true;
		}

		// Utilizamos expresiones regulares para extraer el contenido entre las etiquetas "<respuesta_correcta>"
		preg_match('/respuesta_correcta&gt;([^&]+)&lt;\/respuesta_correcta/', $fullText, $matches);

		// Si encuentra la etiqueta <respuesta_correcta>, actualiza el texto completo y la variable $fullText
		if(isset($matches[1])) {
			$value = $matches[1];
			$fullText = "<input type='checkbox' class='opcion_correcta' id='opcion_correcta$value$idRespuetas' name='opcion' value='" . $value . "'/>" . 
				"<label for='opcion_correcta$value$idRespuetas'>" . $value . "</label><br>";
			return true;
		}


		// Utilizamos expresiones regulares para extraer el contenido entre las etiquetas "<respuesta>"
		preg_match('/respuesta&gt;([^&]+)&lt;\/respuesta/', $fullText, $matches);

		// Si encuentra la etiqueta <respuesta>, actualiza el texto completo y la variable $fullText
		if(isset($matches[1])) {
			$value = $matches[1];
			$fullText = "<input type='checkbox' class='opcion_incorrecta' id='opcion$value$idRespuetas' name='opcion' value='" . $value . "'/>" . 
				"<label for='opcion$value$idRespuetas'>" . $value . "</label><br>";
			return true;
		}

		return false;
	}

	public function checkIfCustomPager(&$fullText)
	{

		$contenido_decodificado = html_entity_decode($fullText);

		if (strpos($contenido_decodificado, "<page_inicio>") !== false) {
			$idPaginador = $this->idPaginador++;

			$active = "";
			$text = "";

			if($idPaginador == 1){
				$active = "active";
				$text = "<script>
					window.addEventListener('DOMContentLoaded', function() {
							generarPaginacion();
							});
				</script>";
			}

			$text .= "<div id='page$idPaginador' class='page $active'>";
			$fullText = $text;
			return true;
		}


		if (strpos($contenido_decodificado, "<page_fin>") !== false) {
			$fullText = "</div>";
			return true;
		}


		return false;
	}




	public function addStyle(&$fullText, $element, $style){
return;
		$fullTextWithStyle = "";
		$originalFullText = "";
		foreach ($element->getElements() as $text) {
			if ($text instanceof \PhpOffice\PhpWord\Element\Text) {
				$font = $text->getFontStyle();
				$textRaw = $text->getText();

				if($font->isBold() && $font->isItalic()){
					$fullTextWithStyle .= "<b><i>$textRaw</i></b>";
				}else if($font->isBold()){
					$fullTextWithStyle .= "<b>$textRaw</b>";
				}else if($font->isItalic()){
					$fullTextWithStyle .= "<i>$textRaw</i>";
				}else{
					$fullTextWithStyle .= $textRaw;
				}
				$originalFullText .= $textRaw;
			} elseif ($text instanceof \PhpOffice\PhpWord\Element\Image) {
				$this->imagesPath[] = $text;
				$imagePath = $text->getSource();
				$name = basename($imagePath);
				$fullText .= '<div style="page-break-before: always;">';
				$fullText .= '<img alt="Figura" fallback="alt" src="imagenes/media/' . $name . '" title="Figura" class="materialboxed responsive-img imagenContenido initialized"/>';
				$fullText .= '</div>';
			} elseif ($text instanceof \PhpOffice\PhpWord\Element\Link) {
				$txt = $text->getText();
				$href = $text->getSource();
				$fullText .= "<a href=\"$href\" target=\"_blank\"><span class=\"underline subrayado\" style=\"display: inline;\">$txt</span></a>";
			}elseif ($text instanceof \PhpOffice\PhpWord\Element\TextRun) {

			}elseif ($text instanceof \PhpOffice\PhpWord\Element\Table) {

			}
		}

		$fullText = str_replace($originalFullText, $fullTextWithStyle, $fullText);

		if($style == "Prrafodelista"){
			$fullText = "<ul><li><p>$fullText</p></li></ul>";
		}else{
			if($fullText){
				$fullText = "<p>$fullText</p>";
			}
		}

	}

	public function getAllWords($filePath)
	{
		$phpWord = IOFactory::load($filePath);

		$return = 0;

		foreach ($phpWord->getSections() as $section) {
			foreach ($section->getElements() as $element) {
				if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
					$fullText = $element->getText();

					$return += strlen($fullText);


				} elseif ($element instanceof \PhpOffice\PhpWord\Element\Image) {

				} elseif ($element instanceof \PhpOffice\PhpWord\Element\TextBreak) {

				} elseif ($element instanceof \PhpOffice\PhpWord\Element\PageBreak) {

				} elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {

					foreach($element->getRows() as $rowKey => $row){

						foreach($row->getCells() as $cellKey => $cells){

							foreach($cells->getElements() as $cellElement){
								if ($cellElement instanceof \PhpOffice\PhpWord\Element\TextRun) {
									$textCell = $cellElement->getText();
									$return += strlen($textCell);
								}
							}
						}
					}

				}else{

				}
			}

		}
		return $return;
	}

}
