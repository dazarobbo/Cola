<?php

namespace Cola\Database;

/**
 * IStatementGenerator
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
interface IStatementGenerator {
	
	public function onDatabaseDefined($name);
	public function onCreateTable($name);
	public function onTableNameDefined($name);
	public function onPrimaryKeyDefined(TypeCollection $coll);
	public function onTypeDefined(Type $type);
	public function onConstraintDefined();
	public function onForeignKeyDefined();
	public function onCommentDefined($comment);
	
	public function __toString();
	
}