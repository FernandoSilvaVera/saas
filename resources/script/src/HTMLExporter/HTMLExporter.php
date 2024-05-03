<?PHP
namespace HTMLExporter;

class HTMLExporter {

	private $outputPath = "";

	public function __construct($outputPath) {
		$this->outputPath = $outputPath;
	}

	public function saveHTMLFile($html, $nameFile) {
		$outputPath = $this->outputPath . $nameFile;
		file_put_contents($outputPath, $html);
	}

	public function saveImages($images){
		foreach($images as $image){
			$imageData = $image->getImageString();
			$imageName = basename($image->getSource());
			$imagePath = $this->outputPath ."imagenes/media/" . $imageName;
			file_put_contents($imagePath, $imageData);
		}
	}

	public function copyLibraries()
	{

	}

	public function copyLibrariesEPUB($skelEPUBPATH)
	{
		$destinationPath = $skelEPUBPATH . "/tmp";
		$commands = [
			"cp -r $skelEPUBPATH/EPUB '$destinationPath/'",
			"cp -r $skelEPUBPATH/META-INF '$destinationPath/'",
			"cp -r $skelEPUBPATH/mimetype '$destinationPath/'"
		];
		foreach ($commands as $command) 
			exec($command);
	}

	public function saveImagesEPUB($skelEPUBPATH, $images)
	{
		foreach($images as $image){
			$imageData = $image->getImageString();
			$imageName = basename($image->getSource());
			$imagePath = $skelEPUBPATH ."tmp/EPUB/media/" . $imageName;
			file_put_contents($imagePath, $imageData);
		}
	}

	//CREA LOS HTML DE LOS EPUB
	public function saveHTMLFileEPUB($skelEPUBPATH, $html, $name)
	{
		$outputPath = $skelEPUBPATH . "tmp/EPUB/text/" . $name . ".x.html";
		file_put_contents($outputPath, $html);
	}

}

?>
