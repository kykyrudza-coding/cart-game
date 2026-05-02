<?php

namespace Illea\TestExerice\Classes\Contracts;

interface CommandInterface
{
    /**
     * Метод для виконання команди
     */
    public function execute(): void;
}