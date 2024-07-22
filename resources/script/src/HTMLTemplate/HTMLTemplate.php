<?php

namespace HTMLTemplate;

use HTMLExporter\HTMLExporter;

class HTMLTemplate {

	private $html = "";

	private $pages = 1;

	public $htmlExporter = "";

	private $buttons = [
		'<a href="{previous}.html" class="waves-effect" id="botonAnterior">
			<i class="material-icons left">chevron_left</i>Anterior
		</a>',
		'
		<a  href="{next}.html" class="waves-effect" id="botonSiguiente">
			<i class="material-icons right">chevron_right</i>Siguiente 
		</a>
		'
	];

	public function __construct($htmlExporter) {
		$this->htmlExporter = $htmlExporter;
	}

	public function loadTemplate($templatePath) {
		$this->html = file_get_contents($templatePath);
	}

	public function getPages($index) {

		$pages = [];
		$prevKey = null;

		$count = count($index);

		$index[$count+1 . '. Mapa Conceptual'] = '
			<style>
				.alert {
					position: relative;
					padding: 0.75rem 1.25rem;
					 margin-bottom: 1rem;
					border: 1px solid transparent;
					border-radius: 0.25rem;
				}

				.alert-success {
					color: #155724;
				       background-color: #d4edda;
				       border-color: #c3e6cb;
				}
			</style>

			<div class="alert alert-success" role="alert" style="text-align: center">
				¡Puedes desplazarte por el mapa usando la rueda del ratón o moviéndolo hacia los lados!
			</div>

			<script src="https://cdn.jsdelivr.net/npm/markmap-autoloader@latest"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
			<style>
				.markmap {
					position: relative;
				}
				.markmap > svg {
					width: 100%;
					height: 600px;
				}
			</style>

			<div class="markmap">
				<script type="text/template">
					{markmapReplace}
				</script>
			</div>

			<button id="download-btn">Descargar como Imagen</button>

			<script>
				document.getElementById("download-btn").addEventListener("click", function() {
					html2canvas(document.querySelector(".markmap")).then(canvas => {
						let link = document.createElement("a");
						link.download = "mapa_conceptual.png";
						link.href = canvas.toDataURL();
						link.click();
					});
				});
			</script>

		';
		$index[$count+2 . '. Resumen'] = "{summary}";
		$index[$count+3 . '. Preguntas'] = "{questions}";

		$this->index = $this->createIndex($index, 0, $pages, $prevKey);

		return $pages;
	}

	public function insertContent($pos, $title, $maxPages, $content){
		$this->html = str_replace('{li}', $this->index, $this->html);
		$this->html = str_replace('{page}', $pos+1, $this->html);
		$this->html = str_replace("{active} . $pos", "active", $this->html);

		$this->html = str_replace("{h1}", $title, $this->html);
		$this->html = str_replace("{title}", $title, $this->html);
		$this->html = str_replace("{contentHTML}", $content, $this->html);

		if($pos == 0){
			$buttons = $this->buttons[1];
		}else if($pos == $maxPages){
			$buttons = $this->buttons[0];
		}else{
			$buttons = $this->buttons[0];
			$buttons .= $this->buttons[1];
		}

		$buttons = str_replace(["{previous}", "{next}"], [$pos-1, $pos+1], $buttons);
		$this->html = str_replace("{previousNext}", $buttons, $this->html);
		$this->html = str_replace("{numFile}", $pos, $this->html);
	}

	private function createIndex($index, $depth, &$position, &$prevKey) {

		$pos = count($position);
		$liLevels = [
			'<li class="{active}"><a class="primerNivel waves-effect" href="{pageLi}.html">{content}</a></li>',
			'<li class="{active}"><a class="segundoNivel waves-effect" href="{pageLi}.html">{content}</a></li>',
			'<li class="{active}"><a class="tercerNivel waves-effect" href="{pageLi}.html">{content}</a></li>',
		];

		$li = "";
		foreach ($index as $positionContent => $content) {
			if (is_array($content)) {
				// Si es un array, llamar recursivamente y aumentar la profundidad
				$li .= str_replace(['{content}', '{pageLi}', '{active}'], [$positionContent, count($position), "{active}".count($position)], $liLevels[$depth]);
				if($positionContent){
					$position[$positionContent] = $positionContent;
				}
				$prevKey = $positionContent;
				$liAux = $this->createIndex($content, $depth + 1, $position, $prevKey);
				$li.= $liAux;
			} else {
				if($positionContent == "html"){
					if($prevKey != null){
						$position[$prevKey] = $content;
					}
					continue;
				}
				// Si no es un array, procesar el contenido actual
				$li .= str_replace(['{content}', '{pageLi}', '{active}'], [$positionContent, count($position), "{active}".count($position)], $liLevels[$depth]);
				if($content){
					$position[$positionContent] = $content;
				}
			}
		}
		return $li;
	}

	public function saveHTMLFile($page){
		$this->htmlExporter->copyLibraries();
		$this->htmlExporter->saveHTMLFile($this->html, "$page.html");
	}

	public function saveImages($imagesPath){
		$this->htmlExporter->saveImages($imagesPath);
	}

}

?>
