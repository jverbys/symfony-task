<?php
namespace App\Tests\Fixtures;

use App\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture
{
    static public $users = [];

    public function load(ObjectManager $manager)
    {
        $this->addUser($manager, 'user1', 'user1@test.com', false,  [User::ROLE_ADMIN], 'user-1');
        $this->addUser($manager, 'user2', 'user2@test.com', true,  [User::ROLE_ADMIN], 'user-2');
        $this->addUser($manager, 'user3', 'user3', false, [User::ROLE_DEFAULT], 'user-3');
    }

    protected function addUser(ObjectManager $manager, $name, $username, $deleted, $roles, $referenceName)
    {
        $user = new User();
        $user->setName($name);
        $user->setUsername($username);
        $user->setPassword('$2a$10$mHIFYaMDsD3f.Y4EU/6JhuqsHrI0oIbJupUSKGE06kC61rYR9IlFG');
        $user->setDeleted($deleted);
        $this->setReference($referenceName, $user);
        $user->setRoles($roles);
        $manager->persist($user);
        $manager->flush();
        self::$users[] = $user;
    }
}
