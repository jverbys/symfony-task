<?php

namespace App\Tests\Controller\SuperAdmin;

use App\Entity\User;
use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use App\Tests\Fixtures\LoadUserData;
use App\Tests\SuperAdminWebTestCase;

class UpdateUserControllerTest extends SuperAdminWebTestCase
{
    /**
     * @var ReferenceRepository
     */
    protected $fixtures;

    protected function setUp()
    {
        parent::setUp();
        /** @var AbstractExecutor $executor */
        $executor = $this->loadFixtures([LoadUserData::class]);
        $this->fixtures = $executor->getReferenceRepository();
    }

    public function testUpdateUserUrlWorks()
    {
        /** @var User $user */
        $user = $this->fixtures->getReference('user-1');
        $this->client->request("GET", "/superadmin/user/".$user->getId()."/edit");

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testSuperAdminCanUpdateUserData()
    {
        /** @var User $user */
        $user = $this->fixtures->getReference('user-1');
        $crawler = $this->client->request("GET", "/superadmin/user/{$user->getId()}/edit");
        $form = $crawler->selectButton('Save')->form();

        $form['name'] = 'Test1';
        $form['roles'] = [User::ROLE_ADMIN];

        $this->client->submit($form);
        $this->assertStatusCode(200, $this->client);
    }

    public function testSuperAdminCanNotSetEmptyUsername()
    {
        /** @var User $user */
        $user = $this->fixtures->getReference('user-1');
        $crawler = $this->client->request("GET", "/superadmin/user/{$user->getId()}/edit");
        $form = $crawler->selectButton('Save')->form();

        $form['username'] = '';

        $this->client->submit($form);
        $this->assertStatusCode(400, $this->client);
    }
}
