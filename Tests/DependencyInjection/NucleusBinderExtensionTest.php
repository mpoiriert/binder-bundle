<?php

namespace Nucleus\Bundle\BinderBundle\Tests\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NucleusBinderExtensionTest extends WebTestCase
{
    public function test()
    {
        $client = static::createClient();

        $request = new Request();
        $response = new Response();
        $testService = $client->getContainer()->get('test_service');

        $testService->property = uniqid();

        $client->getKernel()->terminate($request,$response);

        $result = $client->getContainer()->get('session')->all();

        $found = false;
        array_walk_recursive($result, function($value) use ($testService, &$found) {
            $found = $found || $value == $testService->property;
        });

        $this->assertTrue($found);
    }
}