<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Tests\AdminWebTestCase;
use App\Tests\Fixtures\LoadUserData;

class DeleteUserControllerTest extends AdminWebTestCase
{
    protected function getFixtureClasses()
    {
        $classes[] = LoadUserData::class;

        return $classes;
    }

    public function testAfterUserDeleteSuccessResponse()
    {
        /** @var User $user */
        $user = $this->fixtures->getReference('user-3');
        $this->client->request("GET", "/admin/user/{$user->getId()}/delete");

        $this->assertStatusCode(200, $this->client);
    }

    public function testNotFoundIsReturnedThanUserDoesNotExist()
    {
        $this->client->request("GET", "/admin/user/non-existing-id/delete");

        $this->assertStatusCode(404, $this->client);
    }
}
