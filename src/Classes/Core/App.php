<?php

namespace Illea\TestExerice\Classes\Core;

use Illea\TestExerice\Classes\Base\Cart;
use Illea\TestExerice\Classes\Base\Grid;
use Illea\TestExerice\Classes\Commands\CommandFactory;
use Illea\TestExerice\Classes\Contracts\AppInterface;
use Illea\TestExerice\Classes\Exceptions\InvalidCommandException;

class App implements AppInterface
{
    private array $config; // Конфігурація програми

    private Grid $grid; // Сітка

    private Cart $cart; // Візок

    private CommandExecutor $executor; // Виконавець команд

    public function __construct()
    {
        $this->config = require_once dirname(__DIR__, 2).'/config.php'; // Завантаження конфігурації
        $this->init(); // Ініціалізація компонентів
    }

    public function run(): void
    {
        echo "\033[33mGrid size: ".$this->grid->getHeight().'x'.$this->grid->getWidth()."\033[0m".PHP_EOL; // Виведення розміру сітки
        while (true) {
            echo "\033[36mEnter command (or type 'exit' to quit): \033[0m"; // Запит команди
            $commandInput = trim(fgets(STDIN)); // Зчитування команди
            if (strtolower($commandInput) === 'exit') {
                break; // Вихід з програми
            }
            try {
                $this->handle($commandInput); // Обробка команди
            } catch (InvalidCommandException $e) {
                echo "\033[31mError: ".$e->getMessage()."\033[0m".PHP_EOL; // Виведення помилки
            }
        }
    }

    /**
     * @throws InvalidCommandException
     */
    private function handle(string $commandInput): void
    {
        $this->executor->executeCommand($commandInput); // Виконання команди
        echo "\033[32mCart position: (".$this->cart->getPosition()['x'].', '.$this->cart->getPosition()['y'].")\033[0m".PHP_EOL; // Виведення позиції візка
        echo "\033[35mCarrying item: ".($this->cart->isCarryingItem() ? 'Yes' : 'No')."\033[0m".PHP_EOL; // Виведення стану перенесення товару
    }

    private function init(): void
    {
        $this->grid = new Grid($this->getHeight(), $this->getWidth()); // Створення сітки
        $this->cart = new Cart($this->grid); // Створення візка
        $commandFactory = new CommandFactory($this->cart); // Створення фабрики команд
        $this->executor = new CommandExecutor($commandFactory); // Створення виконавця команд
    }

    private function getHeight(): int
    {
        return $this->config['grid']['height']; // Отримання висоти сітки з конфігурації
    }

    private function getWidth(): int
    {
        return $this->config['grid']['width']; // Отримання ширини сітки з конфігурації
    }
}