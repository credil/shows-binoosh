<?php 


class Controller {
	private $fullSlidePath;

	public function __construct() {
		$cfg = parse_ini_file("../application.ini");
		$this->fullSlidePath = $cfg['shows-binoosh.rootdir'] . '/' .  $cfg['shows-binoosh.slidedir'] . '/';
	}

	public function listFiles($dir = '') {
		if(empty($dir))  $dir = $this->fullSlidePath;
		return array_values(array_diff(scandir($dir), array('..', '.')));
	}


	public function printFiles($dir = '') {
		if(empty($dir))  $dir = $this->fullSlidePath;
		$f = $this->listFiles($dir);
		
		foreach($f as $path) {
			print($this->printLinkedPath($path) . "<br />\n");
		}
	}

	public function printLinkedPath($p) {
		return "<a href=\"$p\">$p</a>";
	}

}
