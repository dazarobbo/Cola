<?php

namespace Cola\Database;

use Cola\Set;

/**
 * TableCollection
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
class TableCollection extends Set {

	public function __construct() {
		parent::__construct();
	}
	
	public function add(Table &$table = null) {
		
		if($this->Some(function($t) use($table) {
			return $t->getName() === $table->getName(); })){
				throw new \DomainException('Table name must be unique in this collection');
		}
		
		return parent::Add($table);
		
	}

}