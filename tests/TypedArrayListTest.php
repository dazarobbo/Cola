<?php

namespace Cola\Tests;

use Cola\ArrayList;
use Cola\TypedArrayList;

/**
 * TypedArrayListTest
 */
class TypedArrayListTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var TypedArrayList
	 */
	protected $_List;
	
	protected function setUp() {
		
		$this->_List = new TypedArrayList(
			array('hello', 'world', '!'),
			function($v){
				return \is_string($v);
			}
		);
		
	}
	
	public function testAdd(){
		$this->_List->add('hello', 'world');
		$this->assertCount(5, $this->_List);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidAdd1(){
		$this->_List->add(100);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidAdd2(){
		$this->_List->add(new \stdClass());
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidAdd3(){
		$this->_List->add('hello', 100, 'world');
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidConcat(){
		$strings = new ArrayList(array('hello', 100, 'world'));
		$list = $this->_List->concat($strings);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidContains(){
		$this->_List->contains(100);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidIntersect(){
		$list = new ArrayList(array('hello', 100));
		$this->_List->intersect($list);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidIndexOf(){
		$this->_List->indexOf(100);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidInsert(){
		$this->_List->insert(0, 100);
	}
		
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidInsertRange(){
		$list = new ArrayList(array('hello', 100));
		$this->_List->insertRange(1, $list);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidLastIndexOf(){
		$this->_List->lastIndexOf(100);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidOffsetSet(){
		$this->_List[0] = 100;
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidRemove(){
		$this->_List->remove(100);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidSentinelSearch(){
		$this->_List->sentinelSearch(100);
	}
	
}
