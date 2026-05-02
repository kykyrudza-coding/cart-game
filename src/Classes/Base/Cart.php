<?php

namespace Illea\TestExerice\Classes\Base;

use Illea\TestExerice\Classes\Contracts\MovableInterface;
use Illea\TestExerice\Classes\Exceptions\InvalidCommandException;
use Illea\TestExerice\Classes\Traits\Cart\CarryingItemTrait;
use Illea\TestExerice\Classes\Traits\Cart\CartTrait;
use Illea\TestExerice\Classes\Traits\Cart\PositionTrait;

class Cart implements MovableInterface
{
    use CarryingItemTrait, CartTrait, PositionTrait;

    private Move $position; // Позиція візка

    private bool $carryingItem = false; // Чи переносить візок товар

    public function __construct(
        private readonly Grid $grid // Сітка
    ) {
        $this->position = new Move(0, 0); // Початкова позиція візка
    }

    /**
     * @throws InvalidCommandException
     */
    public function move(string $direction, int $steps): void
    {
        switch ($direction) {
            case 'RIGHT':
                $this->right($steps); // Рух вправо
                break;
            case 'LEFT':
                $this->left($steps); // Рух вліво
                break;
            case 'UP':
                $this->up($steps); // Рух вгору
                break;
            case 'DOWN':
                $this->down($steps); // Рух вниз
                break;
        }
    }
}