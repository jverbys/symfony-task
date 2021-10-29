<?php

namespace App\Entity\Interfaces;

interface SoftDeletableInterface
{
    public function isDeleted(): bool;

    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted);
}
