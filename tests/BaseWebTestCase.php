<?php

namespace App\Tests;

use App\Kernel;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class BaseWebTestCase
 * @package Tests
 */
abstract class BaseWebTestCase extends WebTestCase
{
    use FixturesTrait;

    protected static function getKernelClass()
    {
        return Kernel::class;
    }

    /**
     * @param Response $response
     */
    protected function assertNoContentResponse(Response $response)
    {
        /** @var string $content */
        $content = $response->getContent();
        $this->assertEquals(204, $response->getStatusCode(), $content);
        $this->assertEmpty($response->getContent());
    }

    /**
     * @param Client $client
     * @param string $destination
     */
    public function assertRedirectTo(Client $client, $destination)
    {
        $this->assertStatusCode(302, $client);
        $client->followRedirect();

        $this->assertStatusCode(200, $client);
        $crawler = $client->getCrawler();

        $this->assertEquals($destination, $crawler->getUri());
    }
}
