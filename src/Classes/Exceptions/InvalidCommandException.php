<?php

namespace Illea\TestExerice\Classes\Exceptions;

use Exception;

class InvalidCommandException extends Exception
{
    /**
     * Повідомлення про помилку за замовчуванням
     *
     * @var string
     */
    protected $message = 'Invalid command provided.';

    /**
     * Конструктор класу
     *
     * @param string $message Повідомлення про помилку
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}