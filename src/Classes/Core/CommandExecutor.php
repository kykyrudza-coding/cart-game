<?php

namespace Illea\TestExerice\Classes\Core;

use Illea\TestExerice\Classes\Commands\CommandFactory;
use Illea\TestExerice\Classes\Exceptions\InvalidCommandException;

readonly class CommandExecutor
{
    public function __construct(
        private CommandFactory $commandFactory
    ) {}

    /**
     * Виконує команду, створену з рядка команди
     *
     * @param string $commandString Рядок команди для виконання
     * @throws InvalidCommandException Якщо команда недійсна
     */
    public function executeCommand(string $commandString): void
    {
        $commands = $this->commandFactory->createCommands($commandString);

        foreach ($commands as $command) {
            $command->execute();
        }
    }
}