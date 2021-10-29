<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Tests\AdminWebTestCase;
use App\Tests\Fixtures\LoadUserData;

class UpdateUserControllerTest extends AdminWebTestCase
{
    protected function getFixtureClasses()
    {
        $classes[] = LoadUserData::class;

        return $classes;
    }

    public function testUpdateUserUrlWorks()
    {
        /** @var User $user */
        $user = $this->fixtures->getReference('user-1');
        $this->client->request("GET", "/admin/user/{$user->getId()}/edit");

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminCanUpdateUserData()
    {
        /** @var User $user */
        $user = $this->fixtures->getReference('user-2');
        $crawler = $this->client->request("GET", "/admin/user/{$user->getId()}/edit");
        $form = $crawler->selectButton('Save')->form();

        $form['name'] = 'Test1';
        $form['roles'] = [User::ROLE_ADMIN];

        $this->client->submit($form);
        $this->assertStatusCode(200, $this->client);
    }

    public function testAdminCanNotSetEmptyUsername()
    {
        /** @var User $user */
        $user = $this->fixtures->getReference('user-1');
        $crawler = $this->client->request("GET", "/admin/user/{$user->getId()}/edit");
        $form = $crawler->selectButton('Save')->form();

        $form['username'] = '';

        $this->client->submit($form);
        $this->assertStatusCode(400, $this->client);
    }
}
