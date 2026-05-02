<?php

namespace Illea\TestExerice\Classes\Renderer;

use Illea\TestExerice\Classes\Base\Cart;
use Illea\TestExerice\Classes\Base\Grid;
use Illea\TestExerice\Classes\Core\GameState;

class GridRenderer
{
    private const string RESET  = "\033[0m";
    private const string YELLOW = "\033[1;33m";
    private const string CYAN   = "\033[1;36m";
    private const string RED    = "\033[1;31m";
    private const string GREEN  = "\033[1;32m";
    private const string GRAY   = "\033[90m";
    private const string WHITE  = "\033[1;37m";

    public function render(Grid $grid, Cart $cart, GameState $state): void
    {
        echo "\033[2J\033[H";

        $pos      = $cart->getPosition();
        $goal     = $state->getGoalZone();
        $carrying = $state->isCarrying();

        $itemMap = [];
        foreach ($state->getItems() as $item) {
            if (!$item->isPickedUp() && !$item->isDelivered()) {
                $itemMap["{$item->getX()},{$item->getY()}"] = true;
            }
        }

        $w = $grid->getWidth();
        $h = $grid->getHeight();

        echo self::GRAY . '+' . str_repeat('-', $w * 2 + 1) . '+' . self::RESET . PHP_EOL;

        for ($y = $h - 1; $y >= 0; $y--) {
            echo self::GRAY . '|' . self::RESET;

            for ($x = 0; $x < $w; $x++) {
                echo ' ';

                if ($x === $pos['x'] && $y === $pos['y']) {
                    echo ($carrying ? self::CYAN : self::YELLOW) . 'C' . self::RESET;
                } elseif ($x === $goal['x'] && $y === $goal['y']) {
                    echo self::GREEN . 'G' . self::RESET;
                } elseif (isset($itemMap["$x,$y"])) {
                    echo self::RED . '$' . self::RESET;
                } else {
                    echo self::GRAY . '.' . self::RESET;
                }
            }

            echo ' ' . self::GRAY . '|' . self::RESET . PHP_EOL;
        }

        echo self::GRAY . '+' . str_repeat('-', $w * 2 + 1) . '+' . self::RESET . PHP_EOL;

        $carryText = $carrying
            ? self::CYAN . 'Так' . self::RESET
            : self::GRAY . 'Ні' . self::RESET;
        $delivered = $state->getDeliveredCount();
        $total     = $state->getTotalItems();

        echo PHP_EOL;
        echo self::GRAY . 'Позиція: '     . self::WHITE . "({$pos['x']}, {$pos['y']})" . self::RESET;
        echo '   ' . self::GRAY . 'Предмет: ' . $carryText;
        echo '   ' . self::GRAY . 'Доставлено: ' . self::WHITE . "$delivered/$total" . self::RESET;
        echo PHP_EOL . PHP_EOL;
        echo self::GRAY . '[Стрілки/WASD] рух   [Q] вихід' . self::RESET . PHP_EOL;
        echo self::GRAY . self::YELLOW . 'C' . self::RESET . self::GRAY . '=візок   '
            . self::CYAN . 'C' . self::RESET . self::GRAY . '=несе   '
            . self::RED . '$' . self::RESET . self::GRAY . '=предмет   '
            . self::GREEN . 'G' . self::RESET . self::GRAY . '=ціль' . self::RESET . PHP_EOL;

        $lastEvent = $state->getLastEvent();
        if ($lastEvent === 'picked') {
            echo PHP_EOL . self::CYAN . '  >> Підняв предмет! Неси до G <<' . self::RESET . PHP_EOL;
        } elseif ($lastEvent === 'dropped') {
            echo PHP_EOL . self::GREEN . '  >> Предмет доставлено! <<' . self::RESET . PHP_EOL;
        }
    }

    public function renderWin(int $total, int $moves): void
    {
        echo "\033[2J\033[H";
        echo PHP_EOL . PHP_EOL;
        echo self::GREEN;
        echo '  +==============================+' . PHP_EOL;
        echo '  |       *** ПЕРЕМОГА! ***      |' . PHP_EOL;
        echo '  | Всi предмети доставленi!     |' . PHP_EOL;
        echo '  +==============================+' . PHP_EOL;
        echo self::RESET . PHP_EOL;
        echo self::WHITE . "  Предметiв: $total" . self::RESET . PHP_EOL;
        echo self::WHITE . "  Ходiв: $moves" . self::RESET . PHP_EOL;
        echo PHP_EOL;
    }
}
