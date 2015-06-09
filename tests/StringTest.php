<?php

	require_once '../vendor/autoload.php';
	
	use Cola\String;
	use Cola\Set;
	
	$set = Set::fromArray(['John', 'Joan', 'Joseph']);
	$str = new String('一二三四五');
	//$str = new String('Man patīk tēju');
	$str = new String('!');
	
	//echo $str->endsWith(new String('tēju'));
	
	echo $str[0]->codeUnit();