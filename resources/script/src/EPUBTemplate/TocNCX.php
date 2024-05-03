<?php

namespace EPUBTemplate;

class TocNCX {

    public function createTOC_NCX($pathSKEL, $titles)
    {
        $ncx = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $ncx .= '<ncx version="2005-1" xmlns="http://www.daisy.org/z3986/2005/ncx/">' . PHP_EOL;
        $ncx .= '  <head>' . PHP_EOL;
        $ncx .= '    <meta name="dtb:uid" content="urn:uuid:671f498c-e0b7-41ee-957e-598e7b8a611a"/>' . PHP_EOL;
        $ncx .= '    <meta name="dtb:depth" content="1"/>' . PHP_EOL;
        $ncx .= '    <meta name="dtb:totalPageCount" content="0"/>' . PHP_EOL;
        $ncx .= '    <meta name="dtb:maxPageNumber" content="0"/>' . PHP_EOL;
        $ncx .= '  </head>' . PHP_EOL;
        $ncx .= '  <docTitle>' . PHP_EOL;
        $ncx .= '    <text>ud1_practicas_iniciacion_prof_curso2</text>' . PHP_EOL;
        $ncx .= '  </docTitle>' . PHP_EOL;
        $ncx .= '  <navMap>' . PHP_EOL;

        $destino = 1;
	$page = 1;
        $nameHTML = "ch00";

        foreach ($titles as $nivel1 => $subniveles1) {

            $href = "text/$nameHTML$page.x.html";

	    $id = $this->convertHXToID($nivel1);
            $ncx .= '    <navPoint id="navpoint-' . $destino . '" >' . PHP_EOL;
            $ncx .= '      <navLabel><text>' . htmlspecialchars($nivel1) . '</text></navLabel>' . PHP_EOL;
                $ncx .= '        <content src="' . $href . '#' . $id . '"/>' . PHP_EOL;

            $destino++;
		$page++;
            foreach ($subniveles1 as $nivel2 => $subniveles2) {
                $id = $this->convertHXToID($nivel2);

                $ncx .= '      <navPoint id="navpoint-' . $destino . '">' . PHP_EOL;
                $ncx .= '        <navLabel><text>' . htmlspecialchars($nivel2) . '</text></navLabel>' . PHP_EOL;
                $ncx .= '        <content src="' . $href . '#' . $id . '"/>' . PHP_EOL;

                $destino++;

                foreach ($subniveles2 as $nivel3 => $contenido) {
                    $id = $this->convertHXToID($nivel3);

                    $ncx .= '        <navPoint id="navpoint-' . $destino . '">' . PHP_EOL;
                    $ncx .= '          <navLabel><text>' . htmlspecialchars($nivel3) . '</text></navLabel>' . PHP_EOL;
                    $ncx .= '          <content src="' . $href . '#' . $id . '"/>' . PHP_EOL;
                    $ncx .= '        </navPoint>' . PHP_EOL;

                    $destino++;
                }

                $ncx .= '      </navPoint>' . PHP_EOL;
            }

            $ncx .= '    </navPoint>' . PHP_EOL;
        }

        $ncx .= '  </navMap>' . PHP_EOL;
        $ncx .= '</ncx>' . PHP_EOL;

        // Guardar el contenido NCX en un archivo
        file_put_contents($pathSKEL . "/tmp/EPUB/toc.ncx", $ncx);
    }

    private function convertHXToID($HX)
    {
	    return preg_replace('/[^a-zA-Z0-9]+/', '-', $HX);
    }

}

?>
