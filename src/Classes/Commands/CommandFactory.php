<?php

namespace Illea\TestExerice\Classes\Commands;

use Illea\TestExerice\Classes\Base\Cart;
use Illea\TestExerice\Classes\Exceptions\InvalidCommandException;

class CommandFactory
{
    private Cart $cart; // Візок

    public function __construct(Cart $cart)
    {
        $this->cart = $cart; // Ініціалізація візка
    }

    /**
     * @throws InvalidCommandException
     */
    public function createCommands(string $commandString): array
    {
        $parts = explode('-', $commandString); // Розділення командного рядка на частини
        $commands = [];
        $i = 0;

        while ($i < count($parts)) {
            switch ($parts[$i]) {
                case 'PICK':
                    $coords = explode(',', $parts[++$i]);
                    if (count($coords) !== 2) {
                        throw new InvalidCommandException('Invalid PICK command format.'); // Неправильний формат команди PICK
                    }
                    $commands[] = new PickCommand($this->cart, (int) $coords[0], (int) $coords[1]); // Створення команди PICK
                    break;
                case 'DROP':
                    $coords = explode(',', $parts[++$i]);
                    if (count($coords) !== 2) {
                        throw new InvalidCommandException('Invalid DROP command format.'); // Неправильний формат команди DROP
                    }
                    $commands[] = new DropCommand($this->cart, (int) $coords[0], (int) $coords[1]); // Створення команди DROP
                    break;
                case 'RIGHT':
                case 'LEFT':
                case 'UP':
                case 'DOWN':
                    $steps = (int) $parts[++$i];
                    $commands[] = new MoveCommand($this->cart, $parts[$i - 1], $steps); // Створення команди руху
                    break;
                default:
                    throw new InvalidCommandException("Invalid command: $parts[$i]"); // Неправильна команда
            }
            $i++;
        }

        return $commands; // Повернення масиву команд
    }
}