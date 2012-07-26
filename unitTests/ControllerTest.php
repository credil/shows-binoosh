<?php

include("../www/controller/Controller.php");

class ControllerTest extends PHPUnit_Framework_TestCase {
	private $fullSlidePath;
	private $c;

	public function setup() {
		$cfg = parse_ini_file("../application.ini");
		$this->rootDir = $cfg['shows-binoosh.rootdir'];
		$this->fullSlidePath = $this->rootDir . '/' .  $cfg['shows-binoosh.slidedir'] . '/';
		$this->hostname = $cfg['shows-binoosh.hostname'];
		$this->baseURL = $cfg['shows-binoosh.baseURL'];
		$this->slidesURL = 'http://' . $this->hostname . $this->baseURL  . $cfg['shows-binoosh.slidesURL'];
		$this->pointerPath = $this->rootDir . '/www/fetchThis.txt';
		if(file_exists($this->pointerPath))  unlink($this->pointerPath);
		$this->c = new Controller();
	}

	public function testDummy() {
		$this->assertTrue(TRUE);
	}


	/**
	public function testWritableFile() {
		$path = $this->c->getPointerPath();
                $fh = fopen($path, 'w'); 

		$this->assertTrue($fh !== FALSE);
                
                fclose($fh);
	}
	*/

	public function testListFiles() {
		$l = $this->c->listFiles();
		$t = array (
			0 => '1.jpg',
			1 => '2.jpg',
			2 => '3.jpg',
			3 => '4.jpg',
			4 => '5.jpg',
			5 => '6.jpg',
		);
		$this->assertEquals($l, $t);
	}

	public function testIndexToFileName() {
		$expected = '4.jpg';
		$result = $this->c->indexToFileName(3);
		$this->assertEquals($expected, $result);


		$expected = '6.jpg';
		$result = $this->c->indexToFileName(6);
		$this->assertEquals($expected, $result);
		$result = $this->c->indexToFileName(7);
		$this->assertEquals($expected, $result);
		$result = $this->c->indexToFileName(100);
		$this->assertEquals($expected, $result);

		$expected = '1.jpg';
		$result = $this->c->indexToFileName(-100);
		$this->assertEquals($expected, $result);
		$result = $this->c->indexToFileName(0);
		$this->assertEquals($expected, $result);
	}


		

	public function testPrintFiles() {
		$s = $this->c->printFiles();
		$e = '1.jpg<br />
<a href="/shows-binoosh//controller/index.php?i=1">2.jpg</a><br />
<a href="/shows-binoosh//controller/index.php?i=2">3.jpg</a><br />
<a href="/shows-binoosh//controller/index.php?i=3">4.jpg</a><br />
<a href="/shows-binoosh//controller/index.php?i=4">5.jpg</a><br />
<a href="/shows-binoosh//controller/index.php?i=5">6.jpg</a><br />
';

		$this->assertEquals($e, $s,
			sprintf("Expected \n%s\n, got \n%s\n",
				var_export($e, TRUE), var_export($s, TRUE))
		);
	}

	public function testPrintLinkedPath() {
		$p = '1.jpg';
		$e = '<a href="/shows-binoosh//controller/index.php?i=0">1.jpg</a>';
		$r = $this->c->printLinkedPath(0, $p);
		$this->assertEquals($r, $e);
	}

	public function testSetFile() {
		$newPath = '2.jpg';
		$expected = $this->slidesURL . $newPath;
		$this->c->setPointerFile($newPath);

		$result = $this->c->getPointerFile();
		
		$this->assertEquals($expected, $result);
	}

	public function testSetPointerFileByIndex() {
		$newIndex = 3;
		$this->c->setPointerFileByIndex($newIndex);
		$result = $this->c->getPointerFile();
		$expected = 'http://localhost/shows-binoosh/slides/4.jpg';
		$this->assertEquals($expected, $result);
		
	}
	
	
	public function testPrintFowardBackwardControls() {
		$this->c->setPointerFileByIndex(2);
		
		$str = $this->c->printFowardBackwardControls();
		
		
		#$expected = '<font size="+1"><a href="/shows-binoosh//controller/index.php?i=1">&lt;</a></font>'.
		#	'&nbsp<font size="+3"><a href="/shows-binoosh//controller/index.php?i=3">></a></font>'
		#;
		
		$expected = '<a href="/shows-binoosh//controller/index.php?i=1"><font size="+1">&lt;</font></a>&nbsp<a href="/shows-binoosh//controller/index.php?i=3"><font size="+7">&gt</font></a>'
		;
		
		
		$this->assertEquals($expected, $str);
	}
	
	
	public function testIllegalIndex() {
		$this->c->setPointerFileByIndex(-1);
		$i = $this->c->getCurrentIndex();
		$this->assertEquals(0, $i);
		
		$this->c->setPointerFileByIndex('hello');
		$i = $this->c->getCurrentIndex();
		$this->assertEquals(0, $i);
		
	}
	
	
	
	public function testFileIsImage() {
		$this->assertTrue(function_exists('finfo_open'));
		
		$this->assertTrue(function_exists('finfo_file'));
		
		
	}

	
	



}

