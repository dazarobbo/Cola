<?php

namespace Cola\Database;

/**
 * StatementGenerator
 */
abstract class StatementGenerator extends \Cola\Objectj {

	abstract public function generateTableDefinition(Table $table);

}
