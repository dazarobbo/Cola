<?php

namespace Cola\Database;

/**
 * StatementGenerator
 * 
 * @version 1.0.0
 * @since 1.0.0
 * @author dazarobbo <dazarobbo@live.com>
 */
abstract class StatementGenerator {

	abstract public function generateTableDefinition(Table $table);

}