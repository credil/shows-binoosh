<?php 


class Controller {
	private $fullSlidePath;

	public function __construct() {
		$cfg = parse_ini_file(dirname(__FILE__) . "/../../application.ini") ;
		$this->fullSlidePath = $cfg['shows-binoosh.rootdir'] . '/' .  $cfg['shows-binoosh.slidedir'] . '/';
		$this->pointerPath = $cfg['shows-binoosh.rootdir'] . '/www/fetchThis.txt';
		$this->indexURL = $cfg['shows-binoosh.baseURL'] . '/controller/index.php';
		$this->baseURL = $cfg['shows-binoosh.baseURL'];
		$this->hostname = $cfg['shows-binoosh.hostname'];
		$this->slidesURL = 'http://' . $this->hostname . $this->baseURL  . $cfg['shows-binoosh.slidesURL'];
		$this->pointerURL = 'http://' . $this->hostname . $this->baseURL . '/fetchThis.txt';
	}

	public function listFiles($dir = '') {
		if(empty($dir))  $dir = $this->fullSlidePath;
		return array_values(array_diff(scandir($dir), array('..', '.')));
	}

	public function setPointerFileByIndex($i) {
		$files = $this->listFiles('');
	
		$newFile = $files[$i];	

		$this->setPointerFile($newFile);
	}


	public function printFiles($dir = '') {
		if(empty($dir))  $dir = $this->fullSlidePath;
		$f = $this->listFiles($dir);
		
		$s = '';
		$i=0;
		foreach($f as $path) {
			$s .= sprintf($this->printLinkedPath($i, $path) . "<br />\n");
			$i++;
		}

		return $s;
	}

	public function printLinkedPath($i, $p) {
		return '<a href="' . $this->indexURL . "?i=$i" . '">' . $p . '</a>';
	}


	public function indexToFileName($i) {
		$files = $this->listFiles('');

		if($i+1 > count($files))  $i=count($files)-1;
		elseif ($i < 0)  $i=0;

		$file = $files[$i];

		return $file;
	}
	


	public function setPointerFile($p) {
		$pathToWrite = $this->slidesURL . $p;
		
		$fh = fopen($this->pointerPath, 'w') or die("Can't write to file");
		
		fwrite($fh, $pathToWrite);

		fclose($fh);
	}


	public function getPointerFile() {
		return file_get_contents($this->pointerURL);
	}

}
