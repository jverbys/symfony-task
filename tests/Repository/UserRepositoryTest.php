<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Tests\BaseWebTestCase;
use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use App\Tests\Fixtures\LoadUserData;
use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class UserRepositoryTest
 * @package App\Tests\Repository
 */
class UserRepositoryTest extends BaseWebTestCase
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * @var ReferenceRepository
     */
    protected $fixtures;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();
        $container = self::getContainer();
        /** @var AbstractManagerRegistry $managerRegistry */
        $managerRegistry = $container->get('doctrine');
        $this->repository = $managerRegistry->getRepository(User::class);

        /** @var AbstractExecutor $executor */
        $executor = $this->loadFixtures([LoadUserData::class]);
        $this->fixtures = $executor->getReferenceRepository();
    }

    public function testGetByIdReturnsOnlyUndeletedUsers()
    {
        /** @var User $user */
        $user = $this->fixtures->getReference('user-1');
        try {
            $result = $this->repository->getById(strval($user->getId()));
        } catch (NonUniqueResultException $e) {
            $result = -1;
        }

        $this->assertSame($user, $result);
    }

    public function testGetByIdReturnsNullForDeletedUser()
    {
        /** @var User $user */
        $user = $this->fixtures->getReference('user-2');
        try {
            $result = $this->repository->getById(strval($user->getId()));
        } catch (NonUniqueResultException $e) {
            $result = -1;
        }

        $this->assertNull($result);
    }

    public function testReturnsAllUsersOrderedByUsernameAsc()
    {
        /** @var User $user */
        $user = $this->fixtures->getReference('user-1');
        /** @var User $user2 */
        $user2 = $this->fixtures->getReference('user-2');
        /** @var User $user3 */
        $user3 = $this->fixtures->getReference('user-3');

        $result = $this->repository->getAllUsersOrderedByUsernameQuery('ASC')->getResult();

        $this->assertSame([$user, $user2, $user3], $result);
    }
}
