<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

/**
 * Class AdminWebTestCase
 *
 * @package Tests
 */
abstract class AdminWebTestCase extends BaseWebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    /**
     * @var ReferenceRepository
     */
    protected $fixtures;

    abstract protected function getFixtureClasses();

    protected function setUp()
    {
        /** @var AbstractExecutor $executor */
        $executor = $this->loadFixtures($this->getFixtureClasses());
        $this->fixtures = $executor->getReferenceRepository();
        /**
         * @var User $adminUser
         */
        $adminUser = $this->fixtures->getReference('user-1');
        $this->loginAs($adminUser, 'main');
        $this->client = $this->makeClient();
    }
}
