<?php

namespace App\UseCase;

use App\Entity\Interfaces\SoftDeletableInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class DeleteEntityUseCase
 * @package App\UseCase
 */
class DeleteEntityUseCase
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param SoftDeletableInterface $entity
     */
    public function delete(SoftDeletableInterface $entity)
    {
        if (!$entity->isDeleted()) {
            $entity->setDeleted(true);

            $this->em->persist($entity);
            $this->em->flush();
        }
    }
}
