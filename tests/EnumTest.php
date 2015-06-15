<?php

namespace Cola\Tests;

use Cola\Enum;
use Cola\Functions\Number;

class Day extends Enum{
	const SUNDAY = 1;
	const MONDAY = 2;
	const TUESDAY = 3;
	const WEDNESDAY = 4;
	const THURSDAY = 5;
	const FRIDAY = 6;
	const SATURDAY = 7;
}

/**
 * EnumTest
 */
class EnumTest extends \PHPUnit_Framework_TestCase {

	public function testCreation(){
		
		$day = new Day(Day::TUESDAY);
		$this->assertEquals(Day::TUESDAY, $day->getValue());
		
		$day = Day::SATURDAY();
		$this->assertEquals(Day::SATURDAY, $day->getValue());
		
		$day = Day::fromName('MONDAY');
		$this->assertEquals(Day::MONDAY, $day->getValue());
		
		$day = Day::fromName('friday');
		$this->assertEquals(Day::FRIDAY, $day->getValue());
		
		$day = Day::parse(2);
		$this->assertEquals(Day::MONDAY, $day->getValue());
		
	}
	
	public function testComparison(){
		
		$monday = Day::MONDAY();
		$wednesday = Day::WEDNESDAY();
		$friday = Day::FRIDAY();
		
		$this->assertEquals(
				Number::COMPARISON_EQUAL,
				$monday->compareTo(Day::MONDAY()));
		
		$this->assertEquals(
				Number::COMPARISON_LESS_THAN,
				$monday->compareTo($wednesday));
		
		$this->assertEquals(
				Number::COMPARISON_GREATER_THAN,
				$friday->compareTo($monday));
		
	}
	
	public function testDefaultGet(){
		
		$day = Day::MONDAY();
		
		$this->assertEquals(Day::MONDAY, $day->Value);
		$this->assertEquals(Day::MONDAY, $day->undefinedProperty);
		
	}
	
	public function testGetEnumNames(){
		
		$daysOfWeek = array()
			'SUNDAY',
			'MONDAY',
			'TUESDAY',
			'WEDNESDAY',
			'THURSDAY',
			'FRIDAY',
			'SATURDAY'
		);
		
		$beatles = array(
			'John',
			'Paul',
			'George',
			'Ringo'
		);
		
		$this->assertTrue($daysOfWeek === Day::getEnumNames());
		$this->assertFalse($beatles === Day::getEnumNames());
		
	}
	
	public function testGetEnumValues(){
		
		$daysOfWeekValues = \range(1, 7, 1);
		$notValid = array(1, 2, 3);
		
		$this->assertTrue($daysOfWeekValues === Day::getEnumValues());
		$this->assertFalse($notValid === Day::getEnumValues());
		
	}

	public function testGetName(){
		
		$day = Day::MONDAY();
		
		$this->assertEquals('MONDAY', $day->getName());
		
	}
	
	public function testGetType(){
		
		$day = Day::MONDAY();
		
		$this->assertEquals('integer', $day->getType());
		
	}
	
	public function testGetValue(){
		
		$day = Day::MONDAY();
		
		$this->assertEquals(Day::MONDAY, $day->getValue());
		
	}
	
	public function testIsDefined(){
		
		$this->assertTrue(Day::isDefined(Day::MONDAY));
		$this->assertTrue(Day::isDefined(2));
		
		$this->assertFalse(Day::isDefined(100));
		
	}
	
	public function testParse(){
		
		$this->assertNotNull(Day::parse(1));
		$this->assertNotNull(Day::parse(7));
		
		$this->assertNull(Day::parse(100));
		
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSet(){
		
		$day = Day::MONDAY();
		
		$day->Value = Day::WEDNESDAY;
		$this->assertEquals(Day::WEDNESDAY, $day->getValue());
		
		$day->Value = 100;
		
	}
	
	public function testToString(){
		
		$day = Day::MONDAY();
		
		$this->assertEquals('2', \strval($day));
		
		$this->assertNotEquals('100', \strval($day));
		
	}
	
}
