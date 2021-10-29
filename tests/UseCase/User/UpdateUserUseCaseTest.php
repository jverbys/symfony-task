<?php

namespace App\Tests\UseCase\User;

use App\Entity\User;
use App\Event\UserEvent;
use App\UseCase\User\UpdateUserUseCase;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UpdateUserUseCaseTest extends TestCase
{
    /**
     * @var EntityManagerInterface|MockObject
     */
    private $em;

    /**
     * @var UpdateUserUseCase
     */
    private $updateUserUseCase;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function setUp()
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->eventDispatcher = new EventDispatcher();

        $this->updateUserUseCase = new UpdateUserUseCase($this->em, $this->eventDispatcher);
    }

    public function testSavesUpdatesAndDispatchesEvent()
    {
        $user = new User();

        $this->em->expects($this->once())->method('persist');
        $this->em->expects($this->once())->method('flush');
        $this->eventDispatcher->addListener(
            UserEvent::class,
            function (UserEvent $event) use (&$resultingUser) {
                $resultingUser = $event->getUser();
            }
        );

        $this->updateUserUseCase->update($user);
        $this->assertSame($user, $resultingUser);
    }
}
