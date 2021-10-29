<?php

namespace App\Tests\Controller\Admin;

use App\Tests\AdminWebTestCase;
use App\Tests\Fixtures\LoadUserData;

class IndexUserControllerTest extends AdminWebTestCase
{
    protected function getFixtureClasses()
    {
        $classes[] = LoadUserData::class;

        return $classes;
    }

    public function testUserListUrlWorks()
    {
        $this->client->request('GET', '/admin/user/');

        $this->assertStatusCode(200, $this->client);
    }
}
