<?php

require_once '../vendor/autoload.php';

/*
class Beatles extends \Cola\ReadOnlyArrayAccess {
	
	private static $_Arr = [
		'Vocals' => 'John',
		'Bass' => 'Paul',
		'Lead' => 'George',
		'Drums' => 'Ringo'];
	
	public function offsetExists($offset) {
		return isset(static::$_Arr[$offset]);
	}

	public function offsetGet($offset) {
		return static::$_Arr[$offset];
	}

}

$group = new Beatles();

echo $group['Bass'];
$group['Bass'] = 'Ringo';*/