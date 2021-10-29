<?php

namespace App\UseCase\User;

use Knp\Component\Pager\PaginatorInterface;
use App\Repository\Interfaces\UserRepositoryInterface;

class ListUsersUseCase
{
    /**
     * @var UserRepositoryInterface
     */
    private $repo;

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * @var int
     */
    private $pageSize;

    /**
     * ListUsersUseCase constructor.
     *
     * @param UserRepositoryInterface $repo
     * @param PaginatorInterface $paginator
     * @param int            $pageSize
     */
    public function __construct(UserRepositoryInterface $repo, PaginatorInterface $paginator, int $pageSize = 30)
    {
        $this->repo = $repo;
        $this->paginator = $paginator;
        $this->pageSize = $pageSize;
    }

    /**
     * @param int $page
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function getPaginatedResults($page)
    {
        $query = $this->repo->getAllUsersOrderedByUsernameQuery('ASC');

        $paginatedUsers = $this->paginator->paginate(
            $query,
            $page,
            $this->pageSize
        );

        return $paginatedUsers;
    }
}
