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
 * Description of Expression
 *
 * @author Pietro Celeste <p.celeste@spinit.it>
 */
class Expression
{
    public string $expr;
    public string $operator;

    public function __construct(string $expr, string $operator = '=')
    {
        $this->expr = $expr;
        $this->operator = $operator;
    }

    public function __toString(): string
    {
        return $this->expr;
    }

    public function getOperator()
    {
        return $this->operator;
    }
}
