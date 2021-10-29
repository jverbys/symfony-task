<?php

namespace App\EventSubscriber\User;

use App\Event\UserEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserPasswordEncodeSubscriber
 *
 * @package Ito\App\EventSubscriber\User
 */
class UserPasswordEncodeSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * UserPasswordEncodeSubscriber constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            UserEvent::class => 'handle',
        ];
    }

    /**
     * @param UserEvent $event
     */
    public function handle(UserEvent $event)
    {
        $entity = $event->getUser();
        $this->entityManager->clear();

        if ($entity->getPlainPassword()) {
            $password = $this->passwordEncoder
                ->encodePassword($entity, $entity->getPlainPassword());
            $entity->setPassword($password);
        }
    }
}
