<?php

	require_once '../vendor/autoload.php';
	
	use Cola\String;
	use Cola\Set;
	
	$str = new String('一二三四五');
	
	echo $str[0]->codeUnit();
	echo PHP_EOL;
	echo $str->repeat(10);
	echo PHP_EOL;
	echo String::fromCodeUnit(243);
	echo PHP_EOL;
	echo $str->shuffle()->repeat(10);
	echo PHP_EOL;
	echo $str->shuffle()->split('//u')->each(function($c){ printf('(%s)', $c); });
	echo PHP_EOL;
	echo $str->shuffle()->split('//u')->join('::');
	echo PHP_EOL;
	echo json_encode($str);
	echo PHP_EOL;
	echo $str('this is the string -> %s');
	echo PHP_EOL;
	
	echo $str->substring(1, 3);
	