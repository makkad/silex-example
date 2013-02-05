<?php
namespace Acme\MobileNotification;

use Swift_Mailer;
use Twig_Template;

class Mailer
{
    protected $mailerFactory;

    protected $swiftMailer;

    protected $from;

    protected $bcc;

    public function __construct(MailerFactory $mailerFactory, Swift_Mailer $swiftMailer, $from, $bcc = null)
    {
        $this->mailerFactory = $mailerFactory;
        $this->swiftMailer = $swiftMailer;
        $this->from = $from;
        $this->bcc = $bcc;
    }

    public function send(Twig_Template $template, array $data, array $to)
    {
        $message = $this->mailerFactory->createNewEmail()
            ->setSubject($template->renderBlock('subject', $data))
            ->setFrom(array($this->from))
            ->setTo($to)
            ->setBody($template->renderBlock('body', $data), 'text/html');

        if (null !== $this->bcc) {
            $message->setBcc($this->bcc);
        }

        return $this->swiftMailer->send($message);
    }
}