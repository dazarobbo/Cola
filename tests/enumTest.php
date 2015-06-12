<?php

	require_once '../vendor/autoload.php';

	/*
	
	use Cola\Enum;
	use Cola\BitwiseEnum;
	
	class Days extends Enum {
		const SUNDAY = 1;
		const MONDAY = 2;
		const TUESDAY = 3;
		const WEDNESDAY = 4;
		const THURSDAY = 5;
		const FRIDAY = 6;
		const SATURDAY = 7;
	}
	
	class Account extends BitwiseEnum {
		const USER = 1;
		const ADMIN = 2;
		const SUPERUSER = 4;
		const GOD = 8;
	}
	
	$day = Days::FRIDAY();
	echo $day->getName();
	
	echo PHP_EOL . PHP_EOL;
	
	$acc = new Account(Account::USER | Account::SUPERUSER);
	foreach(Account::getConstants() as $name => $value){
		echo 'is ' . ($acc->hasFlag($value) ? '' : 'not ') . $name . PHP_EOL;
	}
	
	$acc->addFlag(Account::GOD);
	
	echo implode(', ', $acc->getNames()); */