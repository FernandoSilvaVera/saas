<?php

namespace App\Services;

use setasign\Fpdi\Tcpdf\Fpdi;

class PdfWatermarkService
{
	    public function addWatermark($sourceFile, $watermarkImage)
	    {
		    $pdf = new Fpdi();

		    // Número de páginas del documento PDF original
		    $pageCount = $pdf->setSourceFile($sourceFile);

		    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
			    $templateId = $pdf->importPage($pageNo);
			    $size = $pdf->getTemplateSize($templateId);

			    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
			    $pdf->useTemplate($templateId);

			    // Ajusta la opacidad de la marca de agua
			    $pdf->SetAlpha(0.5);

			    // Posición y tamaño de la marca de agua
			    $x = ($size['width'] - 50) / 2; // Centrar en la página
			    $y = ($size['height'] - 50) / 2;
			    $w = 50;
			    $h = 50;

			    $pdf->Image($watermarkImage, $x, $y, $w, $h);

			    // Restablecer la opacidad
			    $pdf->SetAlpha(1);
		    }

		    if (file_exists($sourceFile)) {
			    unlink($sourceFile);
		    }

		    $pdf->Output($sourceFile, 'F');
	    }
}
