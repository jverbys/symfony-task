<?php

namespace App\Tests\UseCase\User;

use App\Repository\Interfaces\UserRepositoryInterface;
use App\Repository\UserRepository;
use App\UseCase\User\ListUsersUseCase;
use Doctrine\ORM\AbstractQuery;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ListUsersUseCaseTest extends TestCase
{
    /**
     * @var UserRepositoryInterface|MockObject
     */
    private $repo;

    /**
     * @var PaginatorInterface|MockObject
     */
    private $paginator;

    /**
     * @var AbstractQuery|MockObject
     */
    private $query;

    /**
     * @var PaginationInterface
     */
    private $paginationInterface;

    /**
     * @var ListUsersUseCase
     */
    private $listUsersUseCase;

    public function setUp()
    {
        $this->repo = $this->createMock(UserRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->paginationInterface = $this->createMock(PaginationInterface::class);
        $this->query = $this->createMock(AbstractQuery::class);

        $this->listUsersUseCase = new ListUsersUseCase(
            $this->repo,
            $this->paginator,
            20
        );
    }

    public function testPaginatesResults()
    {
        $this->repo->expects($this->exactly(1))->method('getAllUsersOrderedByUsernameQuery')->willReturn($this->query);

        $this
            ->paginator
            ->expects($this->exactly(1))
            ->method('paginate')
            ->with($this->query, 1, 20)
            ->willReturn($this->paginationInterface);

        $this->assertInstanceOf(
            PaginationInterface::class,
            $this->listUsersUseCase->getPaginatedResults(1)
        );
    }
}
