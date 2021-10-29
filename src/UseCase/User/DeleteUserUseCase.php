<?php

namespace App\UseCase\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class DeleteUserUseCase
 * @package App\UseCase
 */
class DeleteUserUseCase
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * DeleteUserUseCase constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $entity
     */
    public function delete(User $entity)
    {
        if (!$entity->isDeleted()) {
            $entity->setDeleted(true);

            $this->em->persist($entity);
            $this->em->flush();
        }
    }
}
