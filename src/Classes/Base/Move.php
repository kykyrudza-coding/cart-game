<?php

namespace Illea\TestExerice\Classes\Base;

use Illea\TestExerice\Classes\Traits\MoveTrait;

class Move
{
    use MoveTrait;

    public function __construct(int $x = 0, int $y = 0)
    {
        $this->x = $x; // Початкова координата x
        $this->y = $y; // Початкова координата y
    }
}