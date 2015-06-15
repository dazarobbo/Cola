<?php

namespace Cola\Database;

use Cola\Set;

/**
 * TypeCollection
 */
class TypeCollection extends Set {

	public function __construct() {
		parent::__construct();
	}
	
	public function addType(Type $t) {
		return parent::Add($t);
	}
	
	public function &getTypeByName($name){
		
		$set = $this->filter(function($t) use ($name){
			return $t->getName() === $name; });
			
		if($set->isEmpty()){
			$null = null;
			return $null;
		}
		
		return $set->_Storage[0];
			
	}
	
	public function getConstraints(){
		
		$coll = new static();
		
		$coll->_Storage = $this
				->filter(function($t){
					return $t instanceof PrimaryType ||
							$t instanceof ForeignType;
				})
				->toArray();
				
		return $coll;
		
	}
	
	public function getrPimaryTypes(){
		
		$coll = new static();
		
		$coll->_Storage = $this
				->filter(function($t){ return $t instanceof PrimaryType; })
				->toArray();
		
		return $coll;
			
	}
	
	public function getForeignTypes(){
		
		$coll = new static();
		
		$coll->_Storage = $this
				->filter(function($t){ return $t instanceof ForeignType; })
				->toArray();
		
		return $coll;
			
	}
	
	public function __toString() {
		return $this->join(', ');
	}

}