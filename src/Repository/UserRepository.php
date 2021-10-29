<?php

namespace App\Repository;

use App\Entity\User;
use App\Repository\Interfaces\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $order
     *
     * @return Query
     */
    public function getAllUsersOrderedByUsernameQuery(string $order)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->orderBy('u.username', $order);

        return $qb->getQuery();
    }

    /**
     * @param string $id
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getById(string $id)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('u.deleted = 0');
        $qb->andWhere('u.id = :id');
        $qb->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
