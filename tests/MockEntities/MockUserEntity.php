<?php

namespace App\Tests\MockEntities;

use App\Entity\User;

class MockUserEntity extends User
{
    public function setId($id)
    {
        $this->id = $id;
    }
}
