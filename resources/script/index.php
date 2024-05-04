<?php

require_once __DIR__ . '/vendor/autoload.php';

use WordReader\WordReader;
use HTMLTemplate\HTMLTemplate;
use EPUBTemplate\EPUBTemplate;
use ScormTemplate\ScormTemplate;
use HTMLExporter\HTMLExporter;

$scriptPATH = dirname(__FILE__);

$output = __DIR__ . '/entregable/';

exec("cd .");

$wordFilePath = $argv[1];
$outputUser = $argv[2];
if (strpos($outputUser, '/') !== 0) {
	$currentDir = getcwd(); // Obtiene la ruta actual del directorio de trabajo
	$outputUser = $currentDir . '/' . $outputUser; // Combina la ruta actual con la proporcionada
}

// Crear instancias de las clases
$wordReader = new WordReader();
$htmlExporter = new HTMLExporter($output);
$htmlTemplate = new HTMLTemplate($htmlExporter);
$epubTemplate = new EPUBTemplate($htmlExporter);
$scormTemplate = new ScormTemplate($htmlExporter, $scriptPATH);

$htmlTemplatePath = __DIR__ . '/utils/skel/skel.html';
$skelEPUB = __DIR__ . '/utils/skelEPUB/';

// Cargar y leer el contenido del archivo Word
$wordContent = $wordReader->loadWordFile($wordFilePath);
$wordTitles = $wordReader->getTitles($wordFilePath);

$wordReader->convertToHTML($htmlTemplate, $wordContent, $htmlTemplatePath);
$wordReader->convertToEPUB($epubTemplate, $skelEPUB, $wordContent, $wordTitles);
$wordReader->convertToPDF($wordFilePath, $output);
$epubTemplate->moveEPUB($skelEPUB, $output);
$wordReader->moveHTML($output, $outputUser);

$wordReader->convertToSCORM($scormTemplate, $wordContent, $htmlTemplate, $outputUser);

$outputHtmlPath = __DIR__ . '/utils/skelEPUB/tmp/';

?>
