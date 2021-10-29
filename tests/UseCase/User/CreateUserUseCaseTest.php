<?php

namespace App\Tests\UseCase\User;

use App\Entity\User;
use App\Event\UserEvent;
use App\UseCase\User\CreateUserUseCase;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class CreateUserUseCaseTest
 * @package App\Tests\UseCase\User
 */
class CreateUserUseCaseTest extends TestCase
{
    public function testCreateUserDispatchesEventAndSaves()
    {
        $user = new User();

        /** @var EntityManagerInterface|MockObject $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())->method('persist');
        $entityManager->expects($this->once())->method('flush');
        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addListener(
            UserEvent::class,
            function (UserEvent $event) use (&$resultingUser) {
                $resultingUser = $event->getUser();
            }
        );

        $createUserUseCase = new CreateUserUseCase($entityManager, $eventDispatcher);
        $createUserUseCase->create($user);

        $this->assertSame($user, $resultingUser);
    }
}
