<?php

namespace Illea\TestExerice\Classes\Commands;

use Illea\TestExerice\Classes\Base\Cart;
use Illea\TestExerice\Classes\Contracts\CommandInterface;
use Illea\TestExerice\Classes\Exceptions\InvalidCommandException;

readonly class DropCommand implements CommandInterface
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
        if ($this->cart->isCarryingItem()) {
            $this->cart->setCarryingItem(false); // Встановити стан перенесення товару на false
            $this->cart->setPosition($this->x, $this->y); // Встановити позицію візка
            echo "Item dropped on ($this->x, $this->y)".PHP_EOL; // Вивести повідомлення про успішне скидання товару
        } else {
            throw new InvalidCommandException("Cannot drop item at ($this->x, $this->y)"); // Викинути виняток, якщо візок не переносить товар
        }
    }
}