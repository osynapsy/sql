<?php
/*
 * This file is part of the Osynapsy package.
 *
 * (c) Pietro Celeste <p.celeste@osynapsy.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Osynapsy\Sql;

/**
 * Description of Update
 *
 * @author Pietro Celeste <p.celeste@osynasy.net>
 */
class Update extends AbstractSql
{
    public function factory()
    {        
        $fields = implode(', ', array_map(function ($field) {
            $value = $this->values[$field];
            return sprintf('%s = %s', $field, $value instanceof Expression ? (string) $value : ":$field");
        }, array_keys($this->values)));
        $where = $this->whereConditionFactory($this->parameters, 'whr');
        $command = sprintf("UPDATE %s SET %s WHERE %s", $this->table, $fields, $where);
        return $command;
    }
}
