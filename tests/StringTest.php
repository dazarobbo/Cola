<?php

	namespace Cola\Tests;

	use Cola\String;
	
	class StringTest extends \PHPUnit_Framework_TestCase{
		
		public function testCodeUnit(){
			$str = new String('一二三四五');
			$this->assertEquals(19968, $str[0]->codeUnit());
		}
		
		/**
		 * @expectedException \InvalidArgumentException
		 */
		public function testInvalidConstructor(){
			$str = new String(1);
		}
		
		public function testImmutibility(){
			$str1 = new String('一二三四五');
			$str2 = $str1->trim();
			$this->assertNotSame($str1, $str2);
		}
		
		public function testClone(){
			
			$str1 = new String('一二三四五');
			$str2 = clone $str1;
			
			$this->assertSame(\strval($str1), \strval($str2));
			$this->assertNotSame($str1, $str2);
			
		}
		
		public function testCompare(){
			
			$str1 = new String('一二三四五');
			$str2 = new String('一二三四五');
			
			$this->assertEquals(0, $str1->compareTo($str2));

			$str2 = $str2->substring(0, 4);
			$this->assertEquals(1, $str1->compareTo($str2));
			
			$str1 = $str1->substring(0, 1);
			$this->assertEquals(-1, $str1->compareTo($str2));
			
		}
		
		public function testConcat(){
			$str = new String('一二三四五');
			$this->assertEquals('一二三四五abcd', $str->concat('a', 'bc', 'd'));
		}
		
		public function testContains(){
			
			$str = new String('一二三四五');
			
			$this->assertTrue($str->contains(new String('四')));
			$this->assertTrue($str->contains(new String('一二')));
			$this->assertTrue($str->contains(new String('五')));
			$this->assertTrue($str->contains(new String('一二三四五')));
			
			$this->assertFalse($str->contains(new String('a')));
			$this->assertFalse($str->contains(new String('0')));
			
		}
		
		public function testConvertEncoding(){
			
			$str = new String('一二三四五');
			$str = $str->convertEncoding('ASCII');
			
			$this->assertEquals('?????', \strval($str));
			
		}
		
		public function testEndsWith(){
			
			$str = new String('一二三四五');
			
			$this->assertTrue($str->endsWith(new String('五')));
			$this->assertTrue($str->endsWith(new String('二三四五')));
			$this->assertTrue($str->endsWith(new String('一二三四五')));
			$this->assertTrue($str->endsWith(new String('')));
			
			$this->assertFalse($str->endsWith(new String('四')));
			$this->assertFalse($str->endsWith(new String('一')));
			$this->assertFalse($str->endsWith(new String('一二三四')));
			$this->assertFalse($str->endsWith(new String('一二三四五一二三四五')));
			$this->assertFalse($str->endsWith(new String('abc')));
			
		}
		
		public function testCodeUnitToCharacter(){
			$str = String::fromCodeUnit(19968);
			$this->assertEquals('一', \strval($str));
		}
		
		public function testFromString(){
			$str = String::fromString('一二三四五');
			$this->assertEquals('一二三四五', \strval($str));
		}
		
		public function testEncodingSet(){
			
			$str = new String('一二三四五');
			$this->assertEquals(String::ENCODING, $str->getEncoding());
			
			$str = $str->convertEncoding('ASCII');
			$this->assertEquals('ASCII', $str->getEncoding());
			
		}
		
		public function testIterator(){
			
			$str = new String('一二三四五');
			$out = '';
			
			foreach($str as $char){
				$out .= $char;
			}
			
			$this->assertEquals('一二三四五', $out);
			
		}
		
		public function testIndexOf(){
			
			$str = new String('一二三四五');
			
			$this->assertEquals(0, $str->indexOf(new String('一')));
			$this->assertEquals(4, $str->indexOf(new String('五')));
			
			$this->assertEquals(String::NO_INDEX, $str->indexOf(new String('a')));
			
		}
		
		public function testInsert(){
			
			$str = new String('一二三四五');
			
			$str2 = $str->insert(0, new String('abc'));
			$this->assertEquals('abc一二三四五', \strval($str2));
			
			$str3 = $str->insert(5, new String('abc'));
			$this->assertEquals('一二三四五abc', \strval($str3));
			
			$this->assertNotEquals(\strval($str), \strval($str3));
			
		}
		
		public function testInvoke(){
			
			$str = new String('一二三四五');
			
			$this->assertEquals('TEST: 一二三四五', $str('TEST: %s'));
			$this->assertNotEquals('一二三四五', $str('12345, %s'));
			
		}
		
		public function testNullOrEmpty(){
			
			$str = new String('一二三四五');
			$this->assertFalse($str->isNullOrEmpty());
			
			$str = new String('');
			$this->assertTrue($str->isNullOrEmpty());
			
			$str = new String('     ');
			$this->assertFalse($str->isNullOrEmpty());
			
		}
		
		public function testIsNullOrWhitespac(){
			
			$str = new String('一二三四五');
			$this->assertFalse($str->isNullOrWhitespace());
			
			$str = new String('');
			$this->assertTrue($str->isNullOrWhitespace());
			
			$str = new String('     ');
			$this->assertTrue($str->isNullOrWhitespace());
			
		}
		
		public function testJoin(){
			
			$set = \Cola\Set::fromArray([
				'red',
				'green',
				'blue'
			]);
			
			$str = String::join($set, new String('一二三四五'));
			
			$expected = 'red一二三四五green一二三四五blue';
			
			$this->assertEquals($expected, \strval($str));
			
		}
		
		public function testJson(){
			
			$str = new String('一二三四五');
			$expected = '"\u4e00\u4e8c\u4e09\u56db\u4e94"';
			$this->assertEquals($expected, \json_encode($str));
			
		}
		
		public function testLastIndexOf(){
			
			$str = new String('一二三四一');
			
			$this->assertEquals(4, $str->lastIndexOf(new String('一')));
			$this->assertEquals(1, $str->lastIndexOf(new String('二')));
			
			$this->assertEquals(String::NO_INDEX, $str->lastIndexOf(new String('abc')));
			
		}
		
		public function testLcfirst(){
			
			$str = new String('Ça me plaît');
			
			$this->assertEquals('ça me plaît', $str->lcfirst()->__toString());
			$this->assertNotEquals('Ça me plaît', \strval($str->lcfirst()));
			
		}
		
		public function testLength(){
			
			$str = new String('一二三四五');
			$this->assertEquals(5, $str->length());
			
			$str = new String('');
			$this->assertEquals(0, $str->length());
			
			$str = new String('一二三四五');
			$this->assertNotEquals(100, $str->length());
			
		}
		
		public function testOffsetExists(){
			
			$str = new String('一二三四五');
			
			$this->assertTrue(isset($str[0]));
			$this->assertTrue(isset($str[4]));
			
			$this->assertFalse(isset($str[5]));
			
		}
		
		/**
		 * @expectedException \OutOfBoundsException
		 */
		public function testOffsetGet(){
			
			$str = new String('一二三四五');
			
			$this->assertEquals(new String('一'), $str[0]);
			$this->assertEquals(new String('五'), $str[4]);
			
			$str[5];
			
		}
		
		public function testPadLeft(){
			
			$str = new String('一二三四五');
			
			$str2 = $str->padLeft(5, new String('a'));
			$this->assertEquals('aaaaa一二三四五', \strval($str2));
			
			$str3 = $str->padLeft(0, new String('a'));
			$this->assertEquals('一二三四五', \strval($str3));
			
		}
		
		public function testPadRight(){
			
			$str = new String('一二三四五');
			
			$str2 = $str->padRight(5, new String('a'));
			$this->assertEquals('一二三四五aaaaa', \strval($str2));
			
			$str3 = $str->padRight(0, new String('a'));
			$this->assertEquals('一二三四五', \strval($str3));
			
		}
		
		public function testReplace(){
			
			$str = new String('一二三四五');
			
			$str2 = $str->replace(new String('一'), new String('a'));
			$this->assertEquals('a二三四五', \strval($str2));
			
		}
		
		public function testRepeat(){
			
			$str = new String('一二三四五');
			
			$this->assertEquals('一二三四五一二三四五一二三四五', \strval($str->repeat(3)));
			
		}
		
		public function testSubstring(){
			
			$str = new String('一二三四五');
			
			$this->assertEquals('二三四', \strval($str->substring(1, 3)));
			
		}
		
		public function testSerialize(){
			
			$str = new String('一二三四五');
			$ser = \serialize($str);
			
			$str2 = \unserialize($ser);
			$this->assertEquals(\strval($str), \strval($str2));
			
		}
		
		public function testShuffle(){
			
			$str = new String('一二三四五一二三四五一二三四五一二三四五一二三四五');
			
			$this->assertNotEquals(\strval($str), \strval($str->shuffle()));
			
		}
		
		public function testSplit(){
			
			$str = new String('一二三四五');
			
			$set = $str->split();
			$this->assertCount(5, $set);
			
		}
		
		public function testStartsWith(){
			
			$str = new String('一二三四五');
			
			$this->assertTrue($str->startsWith(new String('一二三')));
			
		}
		
		public function testCharArray(){
			
			$str = new String('一二三四五');
			
			$this->assertEquals(\strval($str), \implode('', $str->toCharArray()));
			
		}
		
		public function testToLower(){
			
			$str = new String('ABCDEFG');
			
			$this->assertEquals('abcdefg', \strval($str->toLower()));
			
		}
		
		public function testToUpper(){
			
			$str = new String('abcdefg');
			
			$this->assertEquals('ABCDEFG', \strval($str->toUpper()));
			
		}
		
		public function testTrim(){
			
			$str = new String('   一二三四五   ');
			
			$this->assertEquals('一二三四五', \strval($str->trim()));
			
		}
		
		public function testTrimEnd(){
			
			$str = new String('一二三四五   ');
			
			$this->assertEquals('一二三四五', \strval($str->trimEnd()));
			
		}
		
		public function testTrimStart(){
			
			$str = new String('   一二三四五');
			
			$this->assertEquals('一二三四五', \strval($str->trimStart()));
			
		}
		
		public function testUcfirst(){
			
			$str = new String('ça me plaît');
			
			$this->assertEquals('Ça me plaît', \strval($str->ucfirst()));
			$this->assertNotEquals('ça me plaît', \strval($str->ucfirst()));
			
		}
		
	}
	