<?php

namespace App\Tests\Controller\SuperAdmin;

use App\Entity\User;
use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use App\Tests\Fixtures\LoadUserData;
use App\Tests\SuperAdminWebTestCase;

class DeleteUserControllerTest extends SuperAdminWebTestCase
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

    public function testAfterUserDeleteSuccessResponse()
    {
        /** @var User $user */
        $user = $this->fixtures->getReference('user-1');
        $this->client->request("GET", "/superadmin/user/{$user->getId()}/delete");

        $this->assertStatusCode(200, $this->client);
    }

    public function testNotFoundIsReturnedThanUserDoesNotExist()
    {
        $this->client->request("GET", "/superadmin/user/non-existing-id/delete");

        $this->assertStatusCode(404, $this->client);
    }
}
