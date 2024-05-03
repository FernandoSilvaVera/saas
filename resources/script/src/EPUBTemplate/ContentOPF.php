<?php

namespace EPUBTemplate;

class ContentOPF {

	private $images;
	private $pages;

	public function __construct() 
	{
	}

	public function setImages($images)
	{
		$this->images = $images;
	}

	public function setPages($pages)
	{
		$this->pages = $pages;
	}

	public function createOPF($pathSKEL, $wordTitles)
	{

		$key = array_keys($wordTitles);

		// Crear un nuevo objeto DOMDocument
		$dom = new \DOMDocument('1.0', 'UTF-8');
		$dom->formatOutput = true;
		$package = $dom->createElement('package');
		$dom->appendChild($package);
		$package->setAttribute('version', '2.0');
		$package->setAttribute('xmlns', 'http://www.idpf.org/2007/opf');
		$package->setAttribute('unique-identifier', 'epub-id-1');

		$metadata = $dom->createElement('metadata');
		$package->appendChild($metadata);

		$metadata->setAttribute('xmlns:dc', 'http://purl.org/dc/elements/1.1/');
		$metadata->setAttribute('xmlns:opf', 'http://www.idpf.org/2007/opf');

		// Añadir elementos como dc:identifier, dc:title, etc., siguiendo el mismo método
		$title1 = $dom->createElement('dc:title', $key[0]);
		$title1->setAttribute('id', 'epub-title-1');
		$metadata->appendChild($title1);

		$title2 = $dom->createElement('dc:title', $key[0]);
		$title2->setAttribute('id', 'epub-title-2');
		$metadata->appendChild($title2);

		$fechaActual = date('Y-m-d\TH:i:s\Z', time());
		// Añadir elemento dc:date
		$date = $dom->createElement('dc:date', $fechaActual);
		$date->setAttribute('id', 'epub-date-1');
		$metadata->appendChild($date);

		// Añadir elemento dc:language
		$language = $dom->createElement('dc:language', 'es');
		$metadata->appendChild($language);

		// Añadir elemento dc:creator
		$creator = $dom->createElement('dc:creator', '');
		$creator->setAttribute('id', 'epub-creator-1');
		$metadata->appendChild($creator);

		// Añadir elemento meta
		$meta = $dom->createElement('meta');
//		$meta->setAttribute('name', 'cover');
//		$meta->setAttribute('content', 'portada_jpg');
		$metadata->appendChild($meta);

		// Crear el elemento 'manifest' y añadirlo a 'package'
		$manifest = $dom->createElement('manifest');
		$package->appendChild($manifest);

		$this->addItem($dom, $manifest, 'ncx', 'toc.ncx', 'application/x-dtbncx+xml');
		$this->addItem($dom, $manifest, 'nav', 'nav.x.html', 'application/xhtml+xml');
		$this->addItem($dom, $manifest, 'style', 'styles/stylesheet1.css', 'text/css');
//		$this->addItem($dom, $manifest, 'cover_x.html', 'text/cover.x.html', 'application/x.html+xml');
//		$this->addItem($dom, $manifest, 'title_page_x.html', 'text/title_page.x.html', 'application/x.html+xml');

		foreach($this->pages as $page)
		{
			$this->addItem($dom, $manifest, $page . "_x.html", 'text/' . $page . '.x.html', 'application/xhtml+xml');
		}

//		$this->addItem($dom, $manifest, 'portada_jpgl', 'media/portada.jpg', 'image/jpeg');

		foreach($this->images as $image)
		{
			$imageName = basename($image->getSource());
			$extension = pathinfo($imageName, PATHINFO_EXTENSION);
			$this->addItem($dom, $manifest, $imageName, 'media/' . $imageName, 'image/' . $extension);
		}

		$spine = $dom->createElement('spine');
		$spine->setAttribute('toc', 'ncx');
		$package->appendChild($spine);

		// Añadir elementos 'itemref'
//		$this->addItemRef($dom, $spine, 'cover_x.html');
//		$this->addItemRef($dom, $spine, 'title_page_x.html', 'yes');

		foreach($this->pages as $page)
		{
			$this->addItemRef($dom, $spine, $page . "_x.html");
		}
			
		// Crear el elemento 'guide' y añadirlo a 'package'
		$guide = $dom->createElement('guide');
		$package->appendChild($guide);

		$this->addReference($dom, $guide, 'toc', 'ud1_practicas_iniciacion_prof_curso2', 'nav.x.html');
//		$this->addReference($dom, $guide, 'cover', 'Cover', 'text/cover.x.html');

		// Finalmente, guardar el XML en un archivo o imprimirlo
		$opf = $dom->saveXML();
		file_put_contents($pathSKEL. "/tmp/EPUB/content.opf", $opf);
	}

	public function addItem($dom, $manifest, $id, $href, $mediaType) {
		$item = $dom->createElement('item');
		$item->setAttribute('id', $id);
		$item->setAttribute('href', $href);
		$item->setAttribute('media-type', $mediaType);
		$manifest->appendChild($item);
	}

	public function addItemRef($dom, $spine, $idref, $linear = null) {
		$itemref = $dom->createElement('itemref');
		$itemref->setAttribute('idref', $idref);
		if ($linear !== null) {
			$itemref->setAttribute('linear', $linear);
		}
		$spine->appendChild($itemref);
	}

	public function addReference($dom, $guide, $type, $title, $href) {
		$reference = $dom->createElement('reference');
		$reference->setAttribute('type', $type);
		$reference->setAttribute('title', $title);
		$reference->setAttribute('href', $href);
		$guide->appendChild($reference);
	}

}

?>
