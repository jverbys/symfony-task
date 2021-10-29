<?php

namespace App\Tests\Controller\SuperAdmin;

use App\Entity\User;
use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use App\Tests\Fixtures\LoadUserData;
use App\Tests\SuperAdminWebTestCase;

class CreateUserControllerTest extends SuperAdminWebTestCase
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

    public function testCreateUserUrlWorks()
    {
        $this->client->request('GET', '/superadmin/user/create');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testSuperAdminCanCreateUser()
    {
        $crawler = $this->client->request('GET', '/superadmin/user/create');
        $form = $crawler->selectButton('Save')->form();

        $form['username'] = 'test';
        $form['plainPassword'] = ['first' => 'test123', 'second' => 'test123'];
        $form['name'] = 'test';
        $form['roles'] = [User::ROLE_ADMIN];

        $this->client->submit($form);
        $this->assertStatusCode(201, $this->client);
    }

    public function testSuperAdminCanNotCreateUserWithInvalidData()
    {
        $crawler = $this->client->request('GET', '/superadmin/user/create');
        $form = $crawler->selectButton('Save')->form();

        $form['username'] = '';

        $this->client->submit($form);
        $this->assertStatusCode(400, $this->client);
    }
}
