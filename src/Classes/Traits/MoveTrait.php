<?php

namespace Illea\TestExerice\Classes\Traits;

trait MoveTrait
{
    private int $x = 0;

    private int $y = 0;

    /**
     * Переміщує об'єкт вправо на вказану кількість кроків
     *
     * @param int $steps Кількість кроків
     */
    public function moveRight(int $steps): void
    {
        $this->x += $steps;
    }

    /**
     * Переміщує об'єкт вліво на вказану кількість кроків
     *
     * @param int $steps Кількість кроків
     */
    public function moveLeft(int $steps): void
    {
        $this->x -= $steps;
    }

    /**
     * Переміщує об'єкт вгору на вказану кількість кроків
     *
     * @param int $steps Кількість кроків
     */
    public function moveUp(int $steps): void
    {
        $this->y += $steps;
    }

    /**
     * Переміщує об'єкт вниз на вказану кількість кроків
     *
     * @param int $steps Кількість кроків
     */
    public function moveDown(int $steps): void
    {
        $this->y -= $steps;
    }

    /**
     * Отримує координату X об'єкта
     *
     * @return int Координата X
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * Отримує координату Y об'єкта
     *
     * @return int Координата Y
     */
    public function getY(): int
    {
        return $this->y;
    }
}