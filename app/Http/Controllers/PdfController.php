<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class PdfController extends Controller
{
	public function parsePdfToArray($pdfPath)
	{
		$parser = new Parser();

		$pdf = $parser->parseFile($pdfPath);

		$pages = $pdf->getPages();
		$contentArray = [];

		foreach ($pages as $page) {
			$contentArray[] = $page->getText();
		}

		return response()->json($contentArray);
	}

	public function parsePdfToWord($pdfFile)
	{
		// Crear una instancia del parser
		$parser = new Parser();

		// Parsear el archivo PDF
		$pdf = $parser->parseFile($pdfFile->getPathname());

		// Obtener las páginas del PDF
		$pages = $pdf->getPages();
		$contentArray = [];

		// Crear una instancia de PhpWord
		$phpWord = new PhpWord();

		// Añadir una nueva sección al documento Word
		$section = $phpWord->addSection();

		// Iterar sobre cada página y extraer el texto
		foreach ($pages as $page) {
			$text = $page->getText();
			$contentArray[] = $text;

			// Añadir el texto de la página al documento Word
			$section->addText($text);
		}

		// Guardar el documento Word en el servidor
		$wordFile = 'pdf-to-word-' . time() . '.docx';
		$wordFilePath = storage_path('app/' . $wordFile);
		$writer = IOFactory::createWriter($phpWord, 'Word2007');
		$writer->save($wordFilePath);

		return $wordFilePath;
	}
}
