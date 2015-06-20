<?php

namespace Cola\Tests;

use Cola\BitwiseEnum;

class Account extends BitwiseEnum{
	const GUEST = 1;
	const USER = 2;
	const ADMIN = 4;
	const SUPERUSER = 8;
}

echo '1';

/**
 * BitwiseEnumTest
 */
class BitwiseEnumTest extends \PHPUnit_Framework_TestCase {

	public function testCreation(){
		
		$acc = new Account(Account::USER);
		$this->assertEquals(2, $acc->getValue());
		
		$acc = new Account(Account::USER | Account::SUPERUSER);
		$this->assertEquals(10, $acc->getValue());
		
		$acc = Account::fromInt(11);
		
		$acc = Account::parse('13');
		
	}
	
	public function testAddFlag(){
		
		$acc = Account::GUEST();
		
		$this->assertFalse($acc->hasFlag(Account::ADMIN));
		
		$acc->addFlag(Account::ADMIN);
		
		$this->assertTrue($acc->hasFlag(Account::ADMIN));
		$this->assertEquals(5, $acc->getValue());
		
	}
	
	public function testGetNames(){
		
		$acc = new Account(Account::SUPERUSER | Account::ADMIN);
		
		$names = array('ADMIN', 'SUPERUSER');
		
		$this->assertTrue($acc->getNames() == $names);
		
	}
	
	public function testHasFlag(){
		
		$acc = Account::USER();
		
		if(!$acc->hasFlag(Account::SUPERUSER)){
			$acc->addFlag(Account::SUPERUSER);
		}
		
		$this->assertTrue($acc->hasFlag(Account::SUPERUSER));
		
	}
	
	public function testInvert(){
		
		$acc = new Account(Account::GUEST | Account::ADMIN
				| Account::SUPERUSER);
		
		$this->assertFalse($acc->hasFlag(Account::USER));
		
		$acc->invert();
		
		$this->assertEquals(Account::USER, $acc->getValue());
		
	}

}
