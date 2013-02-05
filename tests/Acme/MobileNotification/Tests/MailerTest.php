<?php
namespace Acme\MobileNotification\Tests;

use Acme\MobileNotification\Mailer;

class MailerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mailerFactory = $this->getMock('Acme\MobileNotification\MailerFactory');
        $this->swift = $this->getMockBuilder('Swift_Mailer')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testSend()
    {
        $this->mailer = new Mailer($this->mailerFactory, $this->swift, 'from@email.it', array('bcc@email.it'));

        $email = $this->getMockBuilder('Swift_Message')
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailerFactory->expects($this->once())
            ->method('createNewEmail')
            ->will($this->returnValue($email));

        $template = $this->getMockBuilder('Acme\MobileNotification\Tests\Twig_TemplateTest')
            ->disableOriginalConstructor()
            ->getMock();

        $template->expects($this->at(0))
            ->method('renderBlock')
            ->with('subject', array('data' => 'dummy'))
            ->will($this->returnValue('fooSubject'));

        $template->expects($this->at(1))
            ->method('renderBlock')
            ->with('body', array('data' => 'dummy'))
            ->will($this->returnValue('fooBody'));

        $email->expects($this->once())
            ->method('setSubject')
            ->with('fooSubject')
            ->will($this->returnValue($email));

        $email->expects($this->once())
            ->method('setFrom')
            ->with(array('from@email.it'))
            ->will($this->returnValue($email));

        $email->expects($this->once())
            ->method('setTo')
            ->with(array('to@email.it'))
            ->will($this->returnValue($email));

        $email->expects($this->once())
            ->method('setBody')
            ->with('fooBody', 'text/html')
            ->will($this->returnValue($email));

        $email->expects($this->once())
            ->method('setBcc')
            ->with(array('bcc@email.it'))
            ->will($this->returnValue($email));

        $this->swift->expects($this->once())
            ->method('send')
            ->with($email);

        $this->mailer->send($template, array('data' => 'dummy'), array('to@email.it'));
    }

    public function testSendNoBcc()
    {
        $this->mailer = new Mailer($this->mailerFactory, $this->swift, 'from@email.it');

        $email = $this->getMockBuilder('Swift_Message')
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailerFactory->expects($this->once())
            ->method('createNewEmail')
            ->will($this->returnValue($email));

        $template = $this->getMockBuilder('Acme\MobileNotification\Tests\Twig_TemplateTest')
            ->disableOriginalConstructor()
            ->getMock();

        $template->expects($this->at(0))
            ->method('renderBlock')
            ->with('subject', array('data' => 'dummy'))
            ->will($this->returnValue('fooSubject'));

        $template->expects($this->at(1))
            ->method('renderBlock')
            ->with('body', array('data' => 'dummy'))
            ->will($this->returnValue('fooBody'));

        $email->expects($this->once())
            ->method('setSubject')
            ->with('fooSubject')
            ->will($this->returnValue($email));

        $email->expects($this->once())
            ->method('setFrom')
            ->with(array('from@email.it'))
            ->will($this->returnValue($email));

        $email->expects($this->once())
            ->method('setTo')
            ->with(array('to@email.it'))
            ->will($this->returnValue($email));

        $email->expects($this->once())
            ->method('setBody')
            ->with('fooBody', 'text/html')
            ->will($this->returnValue($email));

        $email->expects($this->never())
            ->method('setBcc');

        $this->swift->expects($this->once())
            ->method('send')
            ->with($email);

        $this->mailer->send($template, array('data' => 'dummy'), array('to@email.it'));
    }
}