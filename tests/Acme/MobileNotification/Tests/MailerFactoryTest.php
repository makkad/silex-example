<?php
namespace Acme\MobileNotification\Tests;

use Acme\MobileNotification\MailerFactory;

class MailerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateNewEmail()
    {
        $factory = new MailerFactory();

        $this->assertInstanceOf('Swift_Message', $factory->createNewEmail());
    }
}