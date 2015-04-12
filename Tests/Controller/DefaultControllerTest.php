<?php

namespace Kl3sk\ChosenBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

	private function getHostUrl($env, $path = '')
	{
	    return self::$kernel->getContainer()->getParameter('dealon.test.hostname.' . $env).$path;
	}

    public function testDevIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $this->getHostUrl('dev', '/chosen/hello/Klesk'));

        var_dump($crawler->filter('html:contains("Klesk")'));

        $this->assertTrue($crawler->filter('html:contains("Klesk")')->count() > 0);
    }

    public function testProdIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $this->getHostUrl('prod', '/chosen/hello/Klesk'));

        var_dump($crawler->filter('html:contains("Klesk")'));

        $this->assertTrue($crawler->filter('html:contains("Klesk")')->count() > 0);
    }
}
