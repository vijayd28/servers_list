<?php

namespace App\Test\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServerControllerTest extends WebTestCase
{
    public function testListServers()
    {
        $client = static::createClient();

        $client->request('GET', '/v1/severs/list');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testListServersWithQeuryString()
    {
        $client = static::createClient();

        $client->request('GET', '/v1/severs/list?hdd_type=SATA&ram_type=DDR4');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}