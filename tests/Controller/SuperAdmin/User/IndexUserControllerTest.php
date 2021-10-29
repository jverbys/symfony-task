<?php

namespace App\Tests\Controller\SuperAdmin;

use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use App\Tests\Fixtures\LoadUserData;
use App\Tests\SuperAdminWebTestCase;

class IndexUserControllerTest extends SuperAdminWebTestCase
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

    public function testUserListUrlWorks()
    {
        $this->client->request('GET', '/superadmin/user/');

        $this->assertStatusCode(200, $this->client);
    }
}
