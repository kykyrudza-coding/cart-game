<?php

namespace Illea\TestExerice\Classes\Traits\Cart;

use Illea\TestExerice\Classes\Exceptions\InvalidCommandException;

trait CartTrait
{
    /**
     * Переміщує об'єкт вправо на вказану кількість кроків
     *
     * @param int $steps Кількість кроків
     * @throws InvalidCommandException Якщо переміщення виходить за межі
     */
    public function right(int $steps): void
    {
        if ($this->position->getX() + $steps >= $this->grid->getWidth()) {
            throw new InvalidCommandException('Cannot move right, out of bounds');
        }
        $this->position->moveRight($steps);
    }

    /**
     * Переміщує об'єкт вліво на вказану кількість кроків
     *
     * @param int $steps Кількість кроків
     * @throws InvalidCommandException Якщо переміщення виходить за межі
     */
    public function left(int $steps): void
    {
        if ($this->position->getX() - $steps < 0) {
            throw new InvalidCommandException('Cannot move left, out of bounds');
        }
        $this->position->moveLeft($steps);
    }

    /**
     * Переміщує об'єкт вгору на вказану кількість кроків
     *
     * @param int $steps Кількість кроків
     * @throws InvalidCommandException Якщо переміщення виходить за межі
     */
    public function up(int $steps): void
    {
        if ($this->position->getY() + $steps >= $this->grid->getHeight()) {
            throw new InvalidCommandException('Cannot move up, out of bounds');
        }
        $this->position->moveUp($steps);
    }

    /**
     * Переміщує об'єкт вниз на вказану кількість кроків
     *
     * @param int $steps Кількість кроків
     * @throws InvalidCommandException Якщо переміщення виходить за межі
     */
    public function down(int $steps): void
    {
        if ($this->position->getY() - $steps < 0) {
            throw new InvalidCommandException('Cannot move down, out of bounds');
        }
        $this->position->moveDown($steps);
    }
}