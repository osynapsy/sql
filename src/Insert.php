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
 * Description of Insert
 *
 * @author Pietro Celeste <p.celeste@osynasy.net>
 */
class Insert extends AbstractSql
{
    public function __construct($table, array $binds = [])
    {
        $this->table = $table;
        $this->binds = $binds;
    }
    
    public function factory()
    {
        $fields = array_keys($this->binds);
        $placeholders = array_map(
            function ($field) {
                $bind = $this->binds[$field];
                return $bind instanceof Expression ? (string) $bind : ':' . $field;
            },
            $fields
        );
        return sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->table, implode(',', $fields), implode(',', $placeholders));
    }
}
