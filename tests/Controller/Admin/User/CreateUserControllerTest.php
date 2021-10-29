<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Tests\AdminWebTestCase;
use App\Tests\Fixtures\LoadUserData;

class CreateUserControllerTest extends AdminWebTestCase
{
    protected function getFixtureClasses()
    {
        $classes[] = LoadUserData::class;

        return $classes;
    }

    public function testCreateUserUrlWorks()
    {
        $this->client->request('GET', '/admin/user/create');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testSuperAdminCanCreateUser()
    {
        $crawler = $this->client->request('GET', '/admin/user/create');
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
        $crawler = $this->client->request('GET', '/admin/user/create');
        $form = $crawler->selectButton('Save')->form();

        $form['username'] = '';

        $this->client->submit($form);
        $this->assertStatusCode(400, $this->client);
    }
}
