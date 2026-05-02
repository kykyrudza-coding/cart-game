<?php

namespace Illea\TestExerice\Classes\Core;

use Illea\TestExerice\Classes\Base\Item;

class GameState
{
    private array $items;
    private ?Item $carriedItem = null;
    private string $lastEvent = '';

    public function __construct(
        private readonly array $goalZone,
        array $itemPositions
    ) {
        $this->items = array_map(
            fn(array $pos) => new Item($pos[0], $pos[1]),
            $itemPositions
        );
    }

    public function update(int $x, int $y): void
    {
        $this->lastEvent = '';

        if ($this->carriedItem === null) {
            foreach ($this->items as $item) {
                if (!$item->isPickedUp() && !$item->isDelivered() && $item->getX() === $x && $item->getY() === $y) {
                    $item->pickUp();
                    $this->carriedItem = $item;
                    $this->lastEvent = 'picked';
                    return;
                }
            }
        }

        if ($this->carriedItem !== null && $x === $this->goalZone['x'] && $y === $this->goalZone['y']) {
            $this->carriedItem->deliver();
            $this->carriedItem = null;
            $this->lastEvent = 'dropped';
        }
    }

    public function isCarrying(): bool { return $this->carriedItem !== null; }

    public function isWon(): bool
    {
        if (empty($this->items)) {
            return false;
        }
        foreach ($this->items as $item) {
            if (!$item->isDelivered()) {
                return false;
            }
        }
        return true;
    }

    public function getItems(): array { return $this->items; }
    public function getGoalZone(): array { return $this->goalZone; }
    public function getTotalItems(): int { return count($this->items); }
    public function getLastEvent(): string { return $this->lastEvent; }

    public function getDeliveredCount(): int
    {
        return count(array_filter($this->items, fn(Item $item) => $item->isDelivered()));
    }
}
