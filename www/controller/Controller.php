<?php 


class Controller {
	private $fullSlidePath;

	protected $currentIndex;
	
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

	
	/**
	 * Get the list of files in specified directory $dir , minus . and ..
	 *  
	 * If $dir is not specified, it will take $this->fullSildePath
	 *  
	 * @param string $dir 
	 * @return array The list of files in a directory
	 */
	public function listFiles($dir = '') {
		if(empty($dir))  $dir = $this->fullSlidePath;
		return array_values(array_diff(scandir($dir), array('..', '.')));
	}
	
	
	public function countFiles() {
		return count($this->listFiles());
	}
	
	
	/**
	 * Set the pointer file to the file specified by $i
	 * 
	 * @param integer $i
	 */
	public function setPointerFileByIndex($i) {
		if(!(is_numeric($i) && $i >=0)) {
			$i=0;
		}
		$this->currentIndex = $i;
		
		$files = $this->listFiles('');
	
		$newFile = $files[$i];	

		$this->setPointerFile($newFile);
	}

	
	/**
	 * Returns a string consisted list of files in the directory $dir,
	 * hyperlinked from $this->indexURL
	 * 
	 * If $dir is not specified, it will take $this->fullSildePath
	 * 
	 * @param string $dir
	 * @return string
	 */
	public function printFiles($dir = '') {
		if(empty($dir))  $dir = $this->fullSlidePath;
		$f = $this->listFiles($dir);
		
		$s = '';
		$index=0;
		foreach($f as $text) {
			
			if($this->currentIndex != $index) 
				$snippet = $this->printLinkedPath($index, $text);
			else
				$snippet = $text;
				
			$s .= sprintf($snippet . "<br />\n");
			$index++;
		}

		return $s;
	}
	
	
	

	
	/**
	 * Returns a string of the specified string $p, with
	 * the hyperlink $this->indexURL?i=$i
	 * 
	 * @param $i 0-based index of file $p
	 * @param $p The string to be hyperlinked
	 * @return string
	 */
	public function printLinkedPath($i, $p) {
		return '<a href="' . $this->indexURL . "?i=$i" . '">' . $p . '</a>';
	}


	/**
	 * Returns the filename associated with the $i'th file
	 * of the default directory.
	 * 
	 * @param integer $i The index of the file
	 * @return string The file name
	 */
	public function indexToFileName($i) {
		$files = $this->listFiles('');

		if($i+1 > count($files))  $i=count($files)-1;
		elseif ($i < 0)  $i=0;

		$file = $files[$i];

		return $file;
	}
	
	
	
	/**
	 * Generates the string for the < > arrows
	 */
	public function printFowardBackwardControls() {
		$returnStr = '';
		
		$backArrow = '<font size="+1">&lt;</font>';
		$frontArrow = '<font size="+7">&gt</font>';
		
		if($this->currentIndex > 0) {
			$returnStr .= $this->printLinkedPath($this->currentIndex -1, $backArrow);	
		} else {
			$returnStr .= $backArrow;
		}
		
		$returnStr .= '&nbsp';
		
		if($this->currentIndex < $this->countFiles() -1) {
			$returnStr .= $this->printLinkedPath($this->currentIndex +1, $frontArrow);
		} else {
			$returnStr .= $frontArrow;
		}
		
		return $returnStr;
	}



	public function getPointerPath() {
		return $this->pointerPath;
	}
	

	/**
	 * Attempts to write to the pointer file which contains 
	 * the URL which the audience client's will jump to.
	 * 
	 * @param string $p URL of the next ressource to fetch.
	 */
	public function setPointerFile($p) {
		$pathToWrite = $this->slidesURL . $p;
		
		$fh = fopen($this->pointerPath, 'w') or die("Can't write to file");
		
		fwrite($fh, $pathToWrite);

		fclose($fh);
	}

	/**
	 * Get the contents of the pointer file 
	 * (basically what URL are they currently watching)
	 * 
	 * @return string
	 */
	public function getPointerFile() {
		return file_get_contents($this->pointerURL);
	}
	
	/**
	 * 
	 */
	public function getCurrentIndex() {
		return $this->currentIndex;
	}
	
	
	/**
	 * Determines is the file is an image supported by
	 * most browsers
	 * (GIF, JPG, PNG)
	 * 
	 * @param $path string The path of the file
	 * @return boolean TRUE if the file is an accepted image format
	 */
	public function fileIsImage($path) {
		$f = finfo_open($path);
		
		
	}

}
