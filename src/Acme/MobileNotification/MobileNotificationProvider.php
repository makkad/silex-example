<?php
namespace Acme\MobileNotification;

use Acme\MobileNotification\Mailer;
use Acme\MobileNotification\MailerFactory;
use Acme\MobileNotification\Template;
use Silex\ServiceProviderInterface;
use Silex\Application;

class MobileNotificationProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['mailer_factory'] = $app->share(function () use ($app) {
            return new MailerFactory();
        });

        $app['custom_mailer'] = $app->share(function () use ($app) {
            $mailer = new Mailer($app['mailer_factory'], $app['mailer'], $app['config_from'], isset($app['config_bcc']) ?: null);

            return $mailer;
        });

        $app['custom_templating'] = $app->share(function () use ($app) {
            return new Template($app['twig']);
        });
    }

    public function boot(Application $app)
    {
    }
}