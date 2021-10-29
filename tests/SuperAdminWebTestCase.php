<?php

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\KernelBrowser;

/**
 * Class SuperAdminWebTestCase
 * @package Tests
 */
abstract class SuperAdminWebTestCase extends BaseWebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    protected function setUp()
    {
        $this->client = static::makeClient([
            'PHP_AUTH_USER' => $this->getContainer()
                ->getParameter('liip_functional_test.authentication.username'),
            'PHP_AUTH_PW' => $this->getContainer()
                ->getParameter('liip_functional_test.authentication.password'),
        ]);
    }
}
