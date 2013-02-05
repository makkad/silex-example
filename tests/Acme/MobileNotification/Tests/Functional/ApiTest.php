<?php
namespace Acme\MobileNotification\Tests\Functional;

use Silex\WebTestCase;

class ApiTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../../src/app.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();
        $app['custom_mailer'] = $this->getMockBuilder('Acme\MobileNotification\Mailer')
            ->disableOriginalConstructor()
            ->getMock();

        return $app;
    }

    public function testSendSuccessful()
    {
        $this->app['custom_mailer']->expects($this->once())
            ->method('send');

        $client = $this->createClient();
        $client->request(
            'POST',
            '/example1',
            array('email' => 'foo@spa.it')
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"success":true}', $client->getResponse()->getContent());
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testSendFailure()
    {
        $client = $this->createClient();
        $client->request(
            'POST',
            '/foo'
        );

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}