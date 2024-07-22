<?PHP

namespace WordReader;

use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;

// Cargar y leer el contenido del archivo Word
class WordReader {

	public $defaultOutputPATH = "";
	public $word = "";
	public $imagesPath = [];

	public $index = [];

	public $idRespuetas = 0;
	public $idPaginador = 1;

	public function __construct($entregable) {
		$this->defaultOutputPATH = __DIR__ . "/../../" . "$entregable/";
		// Constructor
	}

	public $titleCount = 1;

	private function isTitle($title, $style, $linea)
	{
		switch ($title) {
			case 1:
				return $style == "Ttulo1" || $style == "NormalWeb" || $style == "Heading1";
				break;
			case 2:
				return $style == "Ttulo2" || $style == "Heading2";
				break;
			case 3:
				return $style == "Ttulo3" || $style == "Heading3";
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


	public function loadWordFile($filePath) {

		$phpWord = IOFactory::load($filePath);

		$this->word = $phpWord;

		$estructura = [];

		foreach ($phpWord->getSections() as $section) {
			foreach ($section->getElements() as $element) {
				if ($element instanceof \PhpOffice\PhpWord\Element\TextRun || $element instanceof \PhpOffice\PhpWord\Element\Title) {

					$fullText = null;
					$style = null;

					if($element instanceof \PhpOffice\PhpWord\Element\Title){
						$elementPrev = $element->getText();

						if($elementPrev instanceof \PhpOffice\PhpWord\Element\TextRun){
							$element = $elementPrev;
							$fullText = $element->getText();
						}else{
							$fullText = $elementPrev;
							$style = $element->getStyle();
						}

					}

					if(!$fullText){
						$fullText = $element->getText();
					}


					if(!$style){
						$paragraphStyle = $element->getParagraphStyle();
						$style = $paragraphStyle->getStyleName();
					}


					$lineas = explode("\n", $fullText);

					$saved = false;
					$isTest = false;

					foreach ($lineas as $linea) {



						/* - Poner aqui los title - */

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
								if($element instanceof \PhpOffice\PhpWord\Element\TextRun){
									$this->addStyle($fullText, $element, $style);
								}
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



				} 
				else if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
					$fullText = $element->getText();
					echo $fullText;
					echo "\n";
				}

				elseif ($element instanceof \PhpOffice\PhpWord\Element\Image) {

				} elseif ($element instanceof \PhpOffice\PhpWord\Element\TextBreak) {
//lineas vacias
				} elseif ($element instanceof \PhpOffice\PhpWord\Element\PageBreak) {
//paginas vacias

				} elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {

					$html = '<table>';

					foreach($element->getRows() as $rowKey => $row){

						$html .= '<tr>';

						$onlyOneColumn = 0;

						foreach($row->getCells() as $cellKey => $cells){

							$html .= '<td';

							// Si es la primera celda de la primera fila y solo hay un elemento
							if ($rowKey === 0 && $cellKey === 0 && count($cells->getElements()) === 1) {
								$html .= ' {colspan}';
							}

							$html .= '>';

							$onlyOneColumn++;

							foreach($cells->getElements() as $cellElement){


								if ($cellElement instanceof \PhpOffice\PhpWord\Element\TextRun) {
									$textCell = $cellElement->getText();
									$paragraphStyle = $cellElement->getParagraphStyle();
									$style = $paragraphStyle->getStyleName();

									$this->addStyle($textCell, $cellElement, $style, $paragraphStyle);
									$html .= $textCell;
								}

							}
							$html .= '</td>';

						}
				
						if($onlyOneColumn == 1){
							$html = str_replace("{colspan}", "colspan='4'", $html);
						}

						$html .= '</tr>';

					}

					$html = str_replace("{colspan}", "{colspanOne}'", $html);
					$html .= '</table>';


					if(isset($nivelActual)){
						if (isset($nivelActual[2]) && isset($estructura[$nivelActual[0]]) && 
								isset($estructura[$nivelActual[0]][$nivelActual[1]]) && 
								isset($estructura[$nivelActual[0]][$nivelActual[1]][$nivelActual[2]])) {
							//lvl3
							$estructura[$nivelActual[0]][$nivelActual[1]][$nivelActual[2]] .= $html;

						}else if (isset($nivelActual[1]) && isset($estructura[$nivelActual[0]][$nivelActual[1]])){
							//lvl2
							$estructura[$nivelActual[0]][$nivelActual[1]]["html"] .= $html;
						}else if (isset($nivelActual[0]) && isset($estructura[$nivelActual[0]])) {
							//lvl1
							$estructura[$nivelActual[0]]["html"] .= $html;
						}
					}

				}else{

				}
			}

		}

		return $estructura;
	}

	public function readContent() {

		

		// Lee el contenido del archivo Word
	}

	public function getImages(){
		return $this->imagesPath;
	}

	public function addStyle(&$fullText, $element, $style){

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

	public function PDFtoEPUB(){
		$path = $this->defaultOutputPATH;
		$ruta_pdf = $path . "archivo.pdf";

		// Verifica si el archivo PDF existe en la ruta especificada
		if (file_exists($ruta_pdf)) {
			$nombre_archivo = basename($ruta_pdf);
			$nombre_sin_espacios = str_replace(' ', '_', $nombre_archivo);
			$ruta_nuevo_pdf = dirname($ruta_pdf) . '/' . $nombre_sin_espacios;

			rename($ruta_pdf, $ruta_nuevo_pdf);

			// Convierte el archivo PDF a EPUB
			if (preg_match('/\.pdf$/', $nombre_sin_espacios)) {
				$nombre_sin_extension = pathinfo($nombre_sin_espacios, PATHINFO_FILENAME);
				$ruta_epub = dirname($ruta_nuevo_pdf) . '/' . $nombre_sin_extension . '.epub';
				exec("ebook-convert $ruta_nuevo_pdf $ruta_epub");
				echo 'La conversión ha finalizado. El archivo EPUB se encuentra en: ' . $ruta_epub . PHP_EOL;
			} else {
				echo 'El archivo no tiene la extensión .pdf.' . PHP_EOL;
			}
		} else {
			echo 'El archivo PDF especificado no existe en la ruta proporcionada.' . PHP_EOL;
		}
	}

	public function convertToPDF( $pathWORD, $pathPDF){

		echo "\n---- ConvertTOPDF start ----\n";

		$pathinfo = pathinfo($pathWORD);
		$pdfName = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '.pdf'; // Genera la ruta completa al archivo pdf

		if (copy($pathWORD, $pathPDF . '/download.docx')) {
			$pathWORD = $pathPDF . "download.docx";
			$pathPDF = $pathPDF . "download.pdf";

			$comando = "sudo unoconv -o $pathPDF $pathWORD";

			echo "comando:<br> ";
			echo $comando;
			echo "\n";

			exec($comando, $output);

			echo "\nPDF GENERADO\n";
			print_r($output);

			exec("rm $pathWORD");

		} else {
			echo "Hubo un error al copiar el archivo.";
		}
	}

	public function convertToEPUB($epubTemplate, $skelEPUBPATH, $wordContent, $wordTitles){
		$epubTemplate->convertToEPUB($this->getImages(), $skelEPUBPATH, $wordContent, $wordTitles);
	}

	public function convertToHTML($htmlTemplate, $wordContent, $htmlTemplatePath){
		$imagesPath = $this->getImages();
		$htmlTemplate->saveImages($imagesPath);

		$pages = $htmlTemplate->getPages($wordContent);

		$pos = 0;
		foreach($pages as $title => $content){
			$htmlTemplate->loadTemplate($htmlTemplatePath);
			$htmlTemplate->insertContent($pos, $title, count($pages)-1, $content);
			$htmlTemplate->saveHTMLFile($pos);
			$pos++;
		}

		$json = json_encode($pages);
		$htmlTemplate->htmlExporter->saveJSON($json);

	}

	public function getTitles($filePath) {
		$phpWord = IOFactory::load($filePath);

		$titles = [];

		foreach ($phpWord->getSections() as $section) {
			foreach ($section->getElements() as $element) {
				if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
					$fullText = $element->getText();
					$paragraphStyle = $element->getParagraphStyle();
					$style = $paragraphStyle->getStyleName();

					$lineas = explode("\n", $fullText);

					foreach ($lineas as $linea) {
						//$this->addTitle($linea, $style, $titles);
						if ($this->isTitle(1, $style, $linea)) {


							// Nivel principal (MP 1, 1., 2., etc.)
							$nivelActual[0] = $fullText;
							$titles[$nivelActual[0]] = [];

						} elseif ($this->isTitle(2, $style, $linea)) {
							// Subnivel (1.1., 1.2., etc.)
							$nivelActual[1] = $fullText;
							$titles[$nivelActual[0]][$nivelActual[1]] = [];

						} elseif ($this->isTitle(3, $style, $linea)) {
							// Sub-subnivel (1.2.1., 1.2.2., etc.)
							$nivelActual[2] = $fullText;
							$titles[$nivelActual[0]][$nivelActual[1]][$nivelActual[2]] = "";
						}
					}
				}
			}
		}
		return $titles;
	}

	public function copy($output, $outputUser)
	{
		$command = "cp -R " . escapeshellarg($output) . "/* " . escapeshellarg($outputUser);
		// Ejecuta el comando
		exec($command);
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

	public function convertToSCORM($scormTemplate, $wordContent, $htmlTemplate, $outputUser){
		$scormTemplate->createSCORM($wordContent, $htmlTemplate, $this->getImages(), $outputUser);
	}

}

?>
