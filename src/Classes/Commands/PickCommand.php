<?php

namespace Illea\TestExerice\Classes\Commands;

use Illea\TestExerice\Classes\Base\Cart;
use Illea\TestExerice\Classes\Contracts\CommandInterface;
use Illea\TestExerice\Classes\Exceptions\InvalidCommandException;

readonly class PickCommand implements CommandInterface
{
    public function __construct(
        private Cart $cart, // Візок
        private int $x, // Координата x
        private int $y // Координата y
    ) {}

    /**
     * @throws InvalidCommandException
     */
    public function execute(): void
    {
        // Перевірка, чи знаходиться візок на вказаних координатах
        if ($this->cart->getPosition()['x'] === $this->x && $this->cart->getPosition()['y'] === $this->y) {
            $this->cart->setCarryingItem(true); // Встановити стан перенесення товару на true
            echo "Item picked on ($this->x, $this->y)".PHP_EOL; // Вивести повідомлення про успішне підняття товару
        } else {
            throw new InvalidCommandException("Cannot pick item at ($this->x, $this->y)"); // Викинути виняток, якщо візок не на вказаних координатах
        }
    }
}