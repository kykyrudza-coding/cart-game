<?php

namespace Illea\TestExerice\Classes\Base;

readonly class Grid
{
    public function __construct(
        private int $height, // Висота сітки
        private int $width   // Ширина сітки
    ) {}

    public function getHeight(): int
    {
        return $this->height; // Отримання висоти сітки
    }

    public function getWidth(): int
    {
        return $this->width; // Отримання ширини сітки
    }
}