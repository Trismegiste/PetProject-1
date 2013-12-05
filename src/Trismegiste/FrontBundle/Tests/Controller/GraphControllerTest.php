<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * GraphControllerTest tests GraphController
 */
class GraphControllerTest extends WebTestCase
{

    protected $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testAbout()
    {
        $this->client->request('GET', '/about');
        $this->assertRegExp('#XXI century#', $this->client->getResponse()->getContent());
    }

    public function testCreatedFail()
    {
        $crawler = $this->client->request('GET', '/graph/create');
        $form = $crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form, ['graph' => ['title' => 'ST']]);
        $this->assertEquals(1, $crawler->filter('div.alert-error:contains("Invalid")')->count());
    }

}