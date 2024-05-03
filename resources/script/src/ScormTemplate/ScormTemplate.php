<?php

namespace ScormTemplate;

use HTMLExporter\HTMLExporter;
use ScormTemplate\ContentOPF;

class ScormTemplate {

	private $pathScript = null;
	private $images = null;

	public function __construct($htmlExporter, $pathScript) {
		$this->pathScript = $pathScript;
		$this->pathScorm = $pathScript . "/tmp/";
	}

	public function createSCORM($wordContent, $htmlTemplate, $images, $outputUser){
		$this->createFolder();
		$this->html($wordContent, $htmlTemplate);
		$this->images($outputUser);
		$this->libraries($outputUser);
		$this->imsmanifest($wordContent);
		$this->zip();
	}

	public function createFolder(){
		if (!file_exists($this->pathScorm)) {
			mkdir($this->pathScorm, 0777, true);
		}
	}

	public function libraries($outputUser){
		$copyJS = $outputUser . "/js";
		$pathJS = $this->pathScorm;

		// Comando para copiar todos los ficheros de una carpeta a otra
		$command = "cp -r " . escapeshellarg($copyJS) . "* " . escapeshellarg($pathJS);
		// Ejecutando el comando
		exec($command, $output, $return_var);

		$copyJS = $outputUser . "/libraries";
		$pathJS = $this->pathScorm;

		// Comando para copiar todos los ficheros de una carpeta a otra
		$command = "cp -r " . escapeshellarg($copyJS) . "* " . escapeshellarg($pathJS);
		// Ejecutando el comando
		exec($command, $output, $return_var);

		$copyJS = $outputUser . "/css";
		$pathJS = $this->pathScorm;

		// Comando para copiar todos los ficheros de una carpeta a otra
		$command = "cp -r " . escapeshellarg($copyJS) . "* " . escapeshellarg($pathJS);
		// Ejecutando el comando
		exec($command, $output, $return_var);
	}

	public function images($outputUser){
		// Construye el camino hacia la carpeta 'imagenes'
		$imagenesPath = $this->pathScorm . "/imagenes";

		// Verifica si la carpeta 'imagenes' existe, si no, la crea
		if (!file_exists($imagenesPath)) {
			mkdir($imagenesPath, 0777, true);
		}

		// Construye el camino hacia la carpeta 'media' dentro de 'imagenes'
		$mediaPath = $imagenesPath . "/media";

		// Verifica si la carpeta 'media' existe, si no, la crea
		if (!file_exists($mediaPath)) {
			mkdir($mediaPath, 0777, true);
		}

		$copyImages = $outputUser . "/imagenes/media/";
		$pathImages = $this->pathScorm . "imagenes/media/";

		// Comando para copiar todos los ficheros de una carpeta a otra
		$command = "cp -r " . escapeshellarg($copyImages) . "* " . escapeshellarg($pathImages);

		// Ejecutando el comando
		exec($command, $output, $return_var);

		// Verificando si el comando se ejecutó correctamente
		if ($return_var === 0) {
			echo "Los ficheros han sido copiados exitosamente.\n";
		} else {
			echo "Ocurrió un error al copiar los ficheros. Código de error: $return_var\n";
		}

	}

	public function zip(){
		$currentDir = getcwd();
		// Ruta al directorio que quieres comprimir
		$path = $this->pathScript . "/tmp";

		// Cambia al directorio de $path, comprime los archivos en scorm.zip, y luego vuelve al directorio original
		// Se utiliza && para encadenar comandos: primero hace cd, luego zip, y finalmente vuelve con cd
		$command = "cd " . escapeshellarg($path) . " && zip -r scorm.zip . && cd " . escapeshellarg($currentDir);

		// Ejecuta el comando
		exec($command);
	}

	public function html($wordContent, $htmlTemplate){
		$pages = $htmlTemplate->getPages($wordContent);
		$pos = 0;

		$this->images = [];

		foreach($pages as $title => $content){
			preg_match_all('/src="imagenes\/media\/(.*?)"/', $content, $matches);

			if(isset($matches[1])){
				foreach($matches[1] as $image){
					$this->images[] = 'imagenes/media/' . $image;
				}
			}

			$content = '
				<script type="text/javascript" src="libraries/jquery-3.2.1.min.js"></script>
				<script type="text/javascript" src="js/scripts.js"></script>
				<link rel="stylesheet" href="css/estilos.css">
				<link rel="stylesheet" href="css/materialize.css">
				' . $content .
				'
				<div id="paginador"></div>
				<div id="botonResponder" style="display: none;">
							    <button onclick="comprobarRespuestas()" class="bonitoBoton">Responder</button>
							    		    </div>
				';
				

			$this->saveHTMLFile($pos++, $title, $content);
		}
	}

	public function saveHTMLFile($pos, $title, $content){
		$title = "<h1>$title</h1>";
		$content = $title . $content;
		$filename = $this->pathScorm . $pos . ".html";
		file_put_contents($filename, $content);
	}

	public function imsmanifest($wordReader){

		// Crear el elemento base del XML
		$xml = new \SimpleXMLElement('<manifest></manifest>');

		// Añadir atributos al elemento raíz
		$namespaces = [
			'xmlns' => 'http://www.imsproject.org/xsd/imscp_rootv1p1p2',
			'xmlns:adlcp' => 'http://www.adlnet.org/xsd/adlcp_rootv1p2',
			'xmlns:imsmd' => 'http://www.imsglobal.org/xsd/imsmd_v1p2',
			'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
			'xsi:schemaLocation' => 'http://www.imsproject.org/xsd/imscp_rootv1p1p2 imscp_rootv1p1p2.xsd http://www.imsglobal.org/xsd/imsmd_rootv1p2p1 imsmd_rootv1p2p1.xsd http://www.adlnet.org/xsd/adlcp_rootv1p2 adlcp_rootv1p2.xsd',
			'identifier' => 'eXeEjemplo647ee5e627c2d74fbd1'
		];

		foreach ($namespaces as $key => $value) {
			$xml->addAttribute($key, $value);
		}

		// Añadir el elemento metadata y sus hijos
		$metadata = $xml->addChild('metadata');
		$metadata->addChild('schema', 'ADL SCORM');
		$metadata->addChild('schemaversion', '1.2');
		$metadata->addChild('adlcp:location', 'imslrm.xml', 'http://www.adlnet.org/xsd/adlcp_rootv1p2');

		// Añadir el elemento organizations
		$organizations = $xml->addChild('organizations');
		$organizations->addAttribute('default', 'eXeEjemplo647ee5e627c2d74fbd2');
		$organization = $organizations->addChild('organization');
		$organization->addAttribute('identifier', 'eXeEjemplo647ee5e627c2d74fbd2');
		$organization->addAttribute('structure', 'hierarchical');
		$organization->addChild('title', '');

		$resourcesIDS = [];
		$id = 0;

		foreach($wordReader as $keylvl1 => $lvl1){

			if($keylvl1 != "html" && is_array($lvl1)){

				// Primer item
				$item1 = $organization->addChild('item');
				$item1->addAttribute('identifier', 'ITEM-' . $id);
				$item1->addAttribute('isvisible', 'true');
				$item1->addAttribute('identifierref', 'RES-' . $id);
				$item1->addChild('title', $keylvl1);

				$resourcesIDS[] = $id++;

				foreach($lvl1 as $key => $lvl2){
					if($key != "html" && is_array($lvl2)){

						$resourcesIDS[] = $id++;

						foreach($lvl2 as $key => $lvl3){

							if($key != "html" && !is_array($lvl3)){
								// Sub-item 1.1
								$subItem1_1 = $item1->addChild('item');
								$subItem1_1->addAttribute('identifier', 'ITEM-' . $id);
								$subItem1_1->addAttribute('isvisible', 'true');
								$subItem1_1->addAttribute('identifierref', 'RES-' . $id);
								$subItem1_1->addChild('title', $key);
								$resourcesIDS[] = $id++;
							}

						}

					}
				}

			}

		}
		// Continuar añadiendo ítems y sub-ítems según sea necesario...

		// Añadir el elemento resources
		$resources = $xml->addChild('resources');

		foreach($resourcesIDS as $resourcesID){
			// Ejemplo de cómo añadir un recurso
			$resource = $resources->addChild('resource');
			$resource->addAttribute('identifier', 'RES-' . $resourcesID);
			$resource->addAttribute('type', 'webcontent');
			$resource->addAttribute('adlcp:scormtype', 'sco', 'http://www.adlnet.org/xsd/adlcp_rootv1p2');
			$resource->addAttribute('href', $resourcesID . '.html');
			$resource->addChild('file')->addAttribute('href', $resourcesID . '.html');
			$resource->addChild('file')->addAttribute('href', "libraries/jquery-3.2.1.min.js");
			$resource->addChild('file')->addAttribute('href', "js/scripts.js");
			$resource->addChild('file')->addAttribute('href', "css/materialize.css");
			$resource->addChild('file')->addAttribute('href', "css/estilos.css");
			$resource->addChild('dependency')->addAttribute('identifierref', "COMMON_FILES");
		}

		foreach($this->images as $image){
			$resource = $resources->addChild('resource');
			$resource->addAttribute('identifier', 'COMMON_FILES');
			$resource->addAttribute('type', 'webcontent');
			$resource->addAttribute('adlcp:scormtype', 'asset');
			$resource->addChild('file')->addAttribute('href', $image);
		}


		// Ejemplo de cómo añadir archivos a un recurso
		// Continuar añadiendo archivos según sea necesario...




		// Guardar el XML en un archivo
		$xml->asXML($this->pathScript . "/tmp/imsmanifest.xml");

		// Guardar eal contenido en un archivo
//		file_put_contaents(, $dom->saveXML());
	}

}

?>
