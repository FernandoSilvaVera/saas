<?php

header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asumiendo que el archivo se sube con el nombre 'wordFile'
    $wordFilePath = $_FILES['wordFile']['tmp_name'];
    $currentDirPath = getcwd();
    $outputDirPath = $currentDirPath . '/descargar';

    // Comprimir la carpeta generada
    $zipFilePath = $currentDirPath . '/output.zip';
    $logFilePath = "./log";

    // Ejecutar el script de conversión
    exec("rm -rf descargar descargar.zip log ./tmp/");
    exec("php index.php $wordFilePath $outputDirPath >> $logFilePath 2>&1", $output, $return_var);

    foreach ($output as $line) {
        echo $line . PHP_EOL;
	echo "\n";
    }

	    $comando = "mv ./tmp/scorm.zip ./descargar/";
	    $output = shell_exec($comando);

	    $comando = "zip -r -0 descargar.zip descargar";
	    $output = shell_exec($comando);


	if (file_exists("descargar.zip")) {
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="' . basename("descargar.zip") . '"');
		readfile("descargar.zip");
	} else {
		echo "Error al comprimir la carpeta.\n";
	}

}

?>
