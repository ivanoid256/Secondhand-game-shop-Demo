<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MyPaymentServiceControllerTest extends WebTestCase
{
    public function testPay()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/customer/pay');
    }

}
