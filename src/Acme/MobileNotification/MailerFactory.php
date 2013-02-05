<?php
namespace Acme\MobileNotification;

use Swift_Message;

class MailerFactory
{
    public function createNewEmail()
    {
        return Swift_Message::newInstance();
    }
}