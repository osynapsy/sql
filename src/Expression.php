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
class SqlExpression
{
    public string $expr;

    public function __construct(string $expr)
    {
        $this->expr = $expr;
    }

    public function __toString(): string
    {
        return $this->expr;
    }
}
