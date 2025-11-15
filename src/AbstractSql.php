<?php
/**
 * This file is part of the Osynapsy package.
 *
 * (c) Pietro Celeste <p.celeste@osynapsy.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Osynapsy\Sql;

/**
 * AbstractSql
 *
 * Base class for building SQL DML statements (INSERT, UPDATE, DELETE) in a structured and backend-driven way.
 * 
 * This class provides common functionality for:
 *  - managing table and column values,
 *  - handling query parameters,
 *  - building WHERE conditions with support for NULL and IN clauses.
 * 
 * Subclasses must implement the {@link factory()} method to generate the final SQL string.
 * 
 * Example usage:
 * <code>
 * class MyInsert extends AbstractSql {
 *     public function factory() {
 *         return 'INSERT INTO ...';
 *     }
 * }
 * </code>
 * 
 * Features:
 *  - Supports automatic binding of values using named placeholders.
 *  - Handles NULL and array values in WHERE clauses.
 *  - Can be extended for database-specific DML (Oracle RETURNING, Postgres RETURNING, etc.).
 *
 * @author Pietro Celeste <p.celeste@osynapsy.net>
 */
abstract class AbstractSql
{
    protected $table;
    protected $values;
    protected $parameters;
    
    public function __construct($table, array $values = [], array $parameters = [])
    {
        $this->table = $table;
        $this->values = $values;
        $this->parameters = $parameters;
    }

    protected function whereConditionFactory(array $conditions, $prefix = '')
    {
        if (empty($conditions)) {
            throw new \Exception('Conditions parameter is empty.');
        }
        $filters = [];
        foreach($conditions as $field => $value) {
            if (is_null($value)) {
                $filters[] = $this->isNullClause($field);
                continue;
            }
            if (is_array($value)) {
                $filters[] = $this->inClauseFactory($field, $value);
                continue;
            }
            $filters[] = $field . " = :". $prefix . $field;
            $this->values[$prefix . $field] = $value;
        }        
        return implode(' AND ', $filters);
    }

    protected function isNullClause($field)
    {
        return sprintf('%s is null', $field);
    }

    protected function inClauseFactory($field, array $values)
    {
        return sprintf("%s in ('%s')", $field, implode("','", $values));
    }
    
    public function &getValues()
    {
        return $this->values;
    }
    
    public abstract function factory();
    
    public function __toString()
    {
        return $this->factory();
    }
}
