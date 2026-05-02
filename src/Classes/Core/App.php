<?php

namespace Illea\TestExerice\Classes\Core;

use Illea\TestExerice\Classes\Base\Cart;
use Illea\TestExerice\Classes\Base\Grid;
use Illea\TestExerice\Classes\Contracts\AppInterface;
use Illea\TestExerice\Classes\Exceptions\InvalidCommandException;
use Illea\TestExerice\Classes\Input\KeyboardInput;
use Illea\TestExerice\Classes\Renderer\GridRenderer;

class App implements AppInterface
{
    private array $config;
    private Grid $grid;
    private Cart $cart;
    private GameState $gameState;
    private GridRenderer $renderer;
    private KeyboardInput $keyboard;
    private int $moveCount = 0;

    public function __construct()
    {
        $this->config = require_once dirname(__DIR__, 2) . '/config.php';
        $this->init();
    }

    public function run(): void
    {
        $this->renderer->render($this->grid, $this->cart, $this->gameState);

        while (true) {
            $key = $this->keyboard->readKey();

            if ($key === 'QUIT') {
                break;
            }

            $moved = $this->processKey($key);

            if ($moved) {
                $pos = $this->cart->getPosition();
                $this->gameState->update($pos['x'], $pos['y']);
            }

            if ($this->gameState->isWon()) {
                $this->renderer->renderWin($this->gameState->getTotalItems(), $this->moveCount);
                break;
            }

            $this->renderer->render($this->grid, $this->cart, $this->gameState);
        }

        $this->keyboard->close();
    }

    private function processKey(string $key): bool
    {
        if (!in_array($key, ['UP', 'DOWN', 'LEFT', 'RIGHT'])) {
            return false;
        }

        try {
            $this->cart->move($key, 1);
            $this->moveCount++;
            return true;
        } catch (InvalidCommandException) {
            return false;
        }
    }

    private function init(): void
    {
        $this->grid      = new Grid($this->config['grid']['height'], $this->config['grid']['width']);
        $this->cart      = new Cart($this->grid);
        $this->gameState = new GameState($this->config['goal'], $this->config['items']);
        $this->renderer  = new GridRenderer();
        $this->keyboard  = new KeyboardInput();
    }
}
