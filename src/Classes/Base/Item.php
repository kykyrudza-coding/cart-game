<?php

namespace Illea\TestExerice\Classes\Base;

class Item
{
    private bool $pickedUp = false;
    private bool $delivered = false;

    public function __construct(
        private readonly int $x,
        private readonly int $y
    ) {}

    public function getX(): int { return $this->x; }
    public function getY(): int { return $this->y; }
    public function isPickedUp(): bool { return $this->pickedUp; }
    public function isDelivered(): bool { return $this->delivered; }

    public function pickUp(): void { $this->pickedUp = true; }

    public function deliver(): void
    {
        $this->pickedUp = false;
        $this->delivered = true;
    }
}
