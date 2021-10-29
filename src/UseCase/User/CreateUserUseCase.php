<?php

namespace App\UseCase\User;

use App\Entity\User;
use App\Event\UserEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class CreateUserUseCase
 * @package App\UseCase\User
 */
class CreateUserUseCase
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * CreateUserUseCase constructor.
     *
     * @param EntityManagerInterface            $em
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        EntityManagerInterface $em,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param User $user
     */
    public function create(User $user)
    {
        $this->eventDispatcher->dispatch(
            new UserEvent($user)
        );

        $this->em->persist($user);
        $this->em->flush();
    }
}
