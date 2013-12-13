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

    public function testGraphicalView()
    {
        // select test graph
        $crawler = $this->client->request('GET', '/');
        $link = $crawler->filter('a:contains("Star Trek")')->eq(0)->link();
        $crawler = $this->client->click($link);
        // view graphx
        $crawler = $this->client->request('GET', '/graph/show');
        $this->assertRegExp('#d3\.v3\.min\.js#', $this->client->getResponse()->getContent());
        // call ajax
        $crawler = $this->client->request('GET', '/graph/nodes/all');
        $dgraph = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertCount(1, $dgraph['nodes']);
        $this->assertCount(0, $dgraph['links']);
        $this->assertEquals('Spock', $dgraph['nodes'][0]['name']);
    }

}