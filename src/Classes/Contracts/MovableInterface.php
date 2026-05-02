<?php

namespace Illea\TestExerice\Classes\Contracts;

interface MovableInterface
{
    /**
     * Метод для переміщення вказаного об'єкта
     *
     * @param string $direction Напрямок переміщення
     * @param int $steps Кількість кроків
     */
    public function move(string $direction, int $steps): void;
}