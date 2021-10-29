<?php

namespace App\Tests\UseCase;

use App\Entity\User;
use App\UseCase\DeleteEntityUseCase;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteEntityUseCaseTest
 * @package App\Tests\UseCase
 */
class DeleteEntityUseCaseTest extends TestCase
{
    public function testDeleteEntity()
    {
        $entity = new User();
        /** @var EntityManagerInterface|MockObject $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->exactly(1))->method('persist')->with($entity);
        $entityManager->expects($this->exactly(1))->method('flush');

        $deleteUseCase = new DeleteEntityUseCase($entityManager);
        $deleteUseCase->delete($entity);
        $this->assertTrue($entity->isDeleted());
    }
}
