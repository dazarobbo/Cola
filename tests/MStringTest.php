<?php

namespace Cola\Tests;

use Cola\MString;
use Cola\Set;

echo '4';

class MStringTest extends \PHPUnit_Framework_TestCase{

	public function testCodeUnit(){
		$str = new MString('一二三四五');
		$this->assertEquals(19968, $str[0]->codeUnit());
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidConstructor(){
		$str = new MString(1);
	}

	public function testImmutibility(){
		$str1 = new MString('一二三四五');
		$str2 = $str1->trim();
		$this->assertNotSame($str1, $str2);
	}

	public function testClone(){

		$str1 = new MString('一二三四五');
		$str2 = clone $str1;

		$this->assertSame(\strval($str1), \strval($str2));
		$this->assertNotSame($str1, $str2);

	}

	public function testCompare(){

		$str1 = new MString('一二三四五');
		$str2 = new MString('一二三四五');

		$this->assertEquals(0, $str1->compareTo($str2));

		$str2 = $str2->substring(0, 4);
		$this->assertEquals(1, $str1->compareTo($str2));

		$str1 = $str1->substring(0, 1);
		$this->assertEquals(-1, $str1->compareTo($str2));

	}

	public function testConcat(){
		$str = new MString('一二三四五');
		$this->assertEquals('一二三四五abcd', $str->concat('a', 'bc', 'd'));
	}

	public function testContains(){

		$str = new MString('一二三四五');

		$this->assertTrue($str->contains(new MString('四')));
		$this->assertTrue($str->contains(new MString('一二')));
		$this->assertTrue($str->contains(new MString('五')));
		$this->assertTrue($str->contains(new MString('一二三四五')));

		$this->assertFalse($str->contains(new MString('a')));
		$this->assertFalse($str->contains(new MString('0')));

	}

	public function testConvertEncoding(){

		$str = new MString('一二三四五');
		$str = $str->convertEncoding('ASCII');

		$this->assertEquals('?????', \strval($str));

	}

	public function testEndsWith(){

		$str = new MString('一二三四五');

		$this->assertTrue($str->endsWith(new MString('五')));
		$this->assertTrue($str->endsWith(new MString('二三四五')));
		$this->assertTrue($str->endsWith(new MString('一二三四五')));
		$this->assertTrue($str->endsWith(new MString('')));

		$this->assertFalse($str->endsWith(new MString('四')));
		$this->assertFalse($str->endsWith(new MString('一')));
		$this->assertFalse($str->endsWith(new MString('一二三四')));
		$this->assertFalse($str->endsWith(new MString('一二三四五一二三四五')));
		$this->assertFalse($str->endsWith(new MString('abc')));

	}

	public function testCodeUnitToCharacter(){
		$str = MString::fromCodeUnit(19968);
		$this->assertEquals('一', \strval($str));
	}

	public function testFromMString(){
		$str = MString::fromString('一二三四五');
		$this->assertEquals('一二三四五', \strval($str));
	}

	public function testEncodingSet(){

		$str = new MString('一二三四五');
		$this->assertEquals(MString::ENCODING, $str->getEncoding());

		$str = $str->convertEncoding('ASCII');
		$this->assertEquals('ASCII', $str->getEncoding());

	}

	public function testIterator(){

		$str = new MString('一二三四五');
		$out = '';

		foreach($str as $char){
			$out .= $char;
		}

		$this->assertEquals('一二三四五', $out);

	}

	public function testIndexOf(){

		$str = new MString('一二三四五');

		$this->assertEquals(0, $str->indexOf(new MString('一')));
		$this->assertEquals(4, $str->indexOf(new MString('五')));

		$this->assertEquals(MString::NO_INDEX, $str->indexOf(new MString('a')));

	}

	public function testInsert(){

		$str = new MString('一二三四五');

		$str2 = $str->insert(0, new MString('abc'));
		$this->assertEquals('abc一二三四五', \strval($str2));

		$str3 = $str->insert(5, new MString('abc'));
		$this->assertEquals('一二三四五abc', \strval($str3));

		$this->assertNotEquals(\strval($str), \strval($str3));

	}

	public function testInvoke(){

		$str = new MString('一二三四五');

		$this->assertEquals('TEST: 一二三四五', $str('TEST: %s'));
		$this->assertNotEquals('一二三四五', $str('12345, %s'));

	}

	public function testNullOrEmpty(){

		$str = new MString('一二三四五');
		$this->assertFalse($str->isNullOrEmpty());

		$str = new MString('');
		$this->assertTrue($str->isNullOrEmpty());

		$str = new MString('     ');
		$this->assertFalse($str->isNullOrEmpty());

	}

	public function testIsNullOrWhitespac(){

		$str = new MString('一二三四五');
		$this->assertFalse($str->isNullOrWhitespace());

		$str = new MString('');
		$this->assertTrue($str->isNullOrWhitespace());

		$str = new MString('     ');
		$this->assertTrue($str->isNullOrWhitespace());

	}

	public function testJoin(){

		$set = Set::fromArray(array(
			'red',
			'green',
			'blue'
		));

		$str = MString::join($set, new MString('一二三四五'));

		$expected = 'red一二三四五green一二三四五blue';

		$this->assertEquals($expected, \strval($str));

	}

	public function testJson(){

		$str = new MString('一二三四五');
		$expected = '"\u4e00\u4e8c\u4e09\u56db\u4e94"';
		$this->assertEquals($expected, \json_encode($str));

	}

	public function testLastIndexOf(){

		$str = new MString('一二三四一');

		$this->assertEquals(4, $str->lastIndexOf(new MString('一')));
		$this->assertEquals(1, $str->lastIndexOf(new MString('二')));

		$this->assertEquals(MString::NO_INDEX, $str->lastIndexOf(new MString('abc')));

	}

	public function testLcfirst(){

		$str = new MString('Ça me plaît');

		$this->assertEquals('ça me plaît', \strval($str->lcfirst()));
		$this->assertNotEquals('Ça me plaît', \strval($str->lcfirst()));

	}

	public function testLength(){

		$str = new MString('一二三四五');
		$this->assertEquals(5, $str->length());

		$str = new MString('');
		$this->assertEquals(0, $str->length());

		$str = new MString('一二三四五');
		$this->assertNotEquals(100, $str->length());

	}

	public function testOffsetExists(){

		$str = new MString('一二三四五');

		$this->assertTrue(isset($str[0]));
		$this->assertTrue(isset($str[4]));

		$this->assertFalse(isset($str[5]));

	}

	/**
	 * @expectedException \OutOfBoundsException
	 */
	public function testOffsetGet(){

		$str = new MString('一二三四五');

		$this->assertEquals(new MString('一'), $str[0]);
		$this->assertEquals(new MString('五'), $str[4]);

		$str[5];

	}

	public function testPadLeft(){

		$str = new MString('一二三四五');

		$str2 = $str->padLeft(5, new MString('a'));
		$this->assertEquals('aaaaa一二三四五', \strval($str2));

	}

	public function testPadRight(){

		$str = new MString('一二三四五');

		$str2 = $str->padRight(5, new MString('a'));
		$this->assertEquals('一二三四五aaaaa', \strval($str2));

	}

	public function testReplace(){

		$str = new MString('一二三四五');

		$str2 = $str->replace(new MString('一'), new MString('a'));
		$this->assertEquals('a二三四五', \strval($str2));

	}

	public function testRepeat(){

		$str = new MString('一二三四五');

		$this->assertEquals('一二三四五一二三四五一二三四五', \strval($str->repeat(3)));

	}

	public function testSubstring(){

		$str = new MString('一二三四五');

		$this->assertEquals('二三四', \strval($str->substring(1, 3)));

	}

	public function testSerialize(){

		$str = new MString('一二三四五');
		$ser = \serialize($str);

		$str2 = \unserialize($ser);
		$this->assertEquals(\strval($str), \strval($str2));

	}

	public function testShuffle(){

		$str = new MString('一二三四五一二三四五一二三四五一二三四五一二三四五');

		$this->assertNotEquals(\strval($str), \strval($str->shuffle()));

	}

	public function testSplit(){

		$str = new MString('一二三四五');

		$set = $str->split();
		$this->assertCount(5, $set);

	}

	public function testStartsWith(){

		$str = new MString('一二三四五');

		$this->assertTrue($str->startsWith(new MString('一二三')));

	}

	public function testCharArray(){

		$str = new MString('一二三四五');

		$this->assertEquals(\strval($str), \implode('', $str->toCharArray()));

	}

	public function testToLower(){

		$str = new MString('ABCDEFG');

		$this->assertEquals('abcdefg', \strval($str->toLower()));

	}

	public function testToUpper(){

		$str = new MString('abcdefg');

		$this->assertEquals('ABCDEFG', \strval($str->toUpper()));

	}

	public function testTrim(){

		$str = new MString('   一二三四五   ');

		$this->assertEquals('一二三四五', \strval($str->trim()));

	}

	public function testTrimEnd(){

		$str = new MString('一二三四五   ');

		$this->assertEquals('一二三四五', \strval($str->trimEnd()));

	}

	public function testTrimStart(){

		$str = new MString('   一二三四五');

		$this->assertEquals('一二三四五', \strval($str->trimStart()));

	}

	public function testUcfirst(){

		$str = new MString('ça me plaît');

		$this->assertEquals('Ça me plaît', \strval($str->ucfirst()));
		$this->assertNotEquals('ça me plaît', \strval($str->ucfirst()));

	}

}
