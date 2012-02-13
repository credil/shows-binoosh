<?php

include("../www/Controller.php");

class ControllerTest extends PHPUnit_Framework_TestCase {
	private $fullSlidePath;
	private $c;

	public function setup() {
		$cfg = parse_ini_file("../application.ini");
		$this->fullSlidePath = $cfg['shows-binoosh.rootdir'] . '/' .  $cfg['shows-binoosh.slidedir'] . '/';
		$this->c = new Controller();
	}

	public function testDummy() {
		$this->assertTrue(TRUE);
	}

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

	public function testPrintFiles() {
		$s = $this->c->printFiles();
		$e = '<a href="1.jpg">1.jpg</a><br />
<a href="2.jpg">2.jpg</a><br />
<a href="3.jpg">3.jpg</a><br />
<a href="4.jpg">4.jpg</a><br />
<a href="5.jpg">5.jpg</a><br />
<a href="6.jpg">6.jpg</a><br />
';

		$this->assertEquals($e, $s);
	}

	public function testPrintLinkedPath() {
		$p = '/slides/1.jpg';
		$e = '<a href="/slides/1.jpg">/slides/1.jpg</a>';
		$r = $this->c->printLinkedPath('/slides/1.jpg');
		$this->assertEquals($r, $e);
	}



}

