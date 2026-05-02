<?php

namespace Illea\TestExerice\Classes\Commands;

use Illea\TestExerice\Classes\Contracts\CommandInterface;
use Illea\TestExerice\Classes\Contracts\MovableInterface;
use Illea\TestExerice\Classes\Exceptions\InvalidCommandException;

readonly class MoveCommand implements CommandInterface
{
    public function __construct(
        private MovableInterface $movable, // Об'єкт, який можна переміщувати
        private string $direction, // Напрямок руху
        private int $steps // Кількість кроків
    ) {}

    /**
     * @throws InvalidCommandException
     */
    public function execute(): void
    {
        // Перевірка, чи є напрямок руху допустимим
        if (!in_array($this->direction, ['RIGHT', 'LEFT', 'UP', 'DOWN'])) {
            throw new InvalidCommandException("Invalid direction: $this->direction"); // Викидання винятку у разі недопустимого напрямку
        }

        // Виконання руху об'єкта у вказаному напрямку на вказану кількість кроків
        $this->movable->move($this->direction, $this->steps);
    }
}