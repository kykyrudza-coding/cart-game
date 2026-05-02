<?php

namespace Illea\TestExerice\Classes\Traits\Cart;

use Illea\TestExerice\Classes\Base\Move;

trait PositionTrait
{
    /**
     * Отримує поточну позицію об'єкта
     *
     * @return array Позиція у форматі ['x' => int, 'y' => int]
     */
    public function getPosition(): array
    {
        return ['x' => $this->position->getX(), 'y' => $this->position->getY()];
    }

    /**
     * Встановлює нову позицію об'єкта
     *
     * @param int $x Координата X
     * @param int $y Координата Y
     */
    public function setPosition(int $x, int $y): void
    {
        $this->position = new Move($x, $y);
    }
}