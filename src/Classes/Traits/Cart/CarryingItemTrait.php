<?php

namespace Illea\TestExerice\Classes\Traits\Cart;

trait CarryingItemTrait
{
    /**
     * Перевіряє, чи несе об'єкт предмет
     *
     * @return bool Статус наявності предмета
     */
    public function isCarryingItem(): bool
    {
        return $this->carryingItem;
    }

    /**
     * Встановлює статус наявності предмета
     *
     * @param bool $status Статус наявності предмета
     */
    public function setCarryingItem(bool $status): void
    {
        $this->carryingItem = $status;
    }
}