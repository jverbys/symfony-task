<?php

namespace App\Repository\Interfaces;

use App\Entity\User;
use Doctrine\ORM\Query;

/**
 * Interface UserRepositoryInterface
 * @package App\Repository\Interfaces
 */
interface UserRepositoryInterface
{
    /**
     * @param string $order
     *
     * @return Query
     */
    public function getAllUsersOrderedByUsernameQuery(string $order);

    /**
     * @param string $id
     * @return User|null
     */
    public function getById(string $id);
}
