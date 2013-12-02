<?php

namespace Trismegiste\FrontBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VertexControllerTest extends WebTestCase
{

    static $client;

    static public function setupBeforeClass()
    {
        static::$client = static::createClient();
    }

    public function testIndex()
    {
        $client = static::$client;
        $client->getContainer()->get('dokudoki.collection')->drop();

        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $create = $crawler->selectLink('Create')->link();
        $client->click($create);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testCreate()
    {
        $client = static::$client;
        $crawler = $client->request('GET', '/vertex/create');
        $form = $crawler->selectButton('Save')->form();
        $crawler = $client->submit($form, ['vertex' => ['infoType' => 'npc', 'title' => 'Spock']]);
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div.alert-success:contains("Created")')->count());
        $this->assertEquals(1, $crawler->filter('h2:contains("Edit npc")')->count());

        $client->click($crawler->selectLink('Spock')->link());
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testListing()
    {
        $client = static::$client;
        $crawler = $client->request('GET', '/');
        $crawler = $client->click($crawler->filter('div.row-fluid li a:contains("Spock")')->eq(0)->link());

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('h2:contains("Npc Spock")')->count());

        return $crawler->filter('a.btn:contains("Edit")')->eq(0)->link();
    }

    /**
     * @depends testListing
     */
    public function testEdit($link)
    {
        $client = static::$client;
        $crawler = $client->click($link);
        $this->assertEquals(1, $crawler->filter('h2:contains("Edit npc")')->count());

        $form = $crawler->selectButton('Save')->form();
        $crawler = $client->submit($form, ['vertex' => ['description' => 'Science officer @notfound']]);
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div.alert-success:contains("Updated")')->count());
    }

    public function testSearch()
    {
        $client = static::$client;
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Search')->form();
        $crawler = $client->submit($form, ['keyword' => 'officer']);

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('div.row-fluid li a:contains("Spock")')->count());
    }

    public function testBroken()
    {
        $client = static::$client;
        $crawler = $client->request('GET', '/check/broken');
        $this->assertEquals(1, $crawler->filter('tbody tr td:contains("notfound")')->count());
    }

}
