<?php

class DummyTest extends PHPUnit_Framework_TestCase {
	public function testDummy() {
		$this->assertTrue(TRUE);
	}

	public function testICanReadCFG() {
		$cfg = parse_ini_file("../application.ini");
		$this->assertTrue(is_array($cfg));
	}
}
