<?php

require_once __DIR__.'/../vendor/autoload.php'; 

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application(); 
$app['swiftmailer.options'] = array(
    'host' => 'host',
    'port' => '25',
    'username' => 'username',
    'password' => 'password',
    'encryption' => null,
    'auth_mode' => null
);
$app['config_from'] = 'from@pingpongstars.it';
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Acme\MobileNotification\MobileNotificationProvider());

$app->error(function (\Exception $e, $code) {
    return $e->getMessage();
});

$app->post('/{slug}', function($slug) use($app) {
    $template = $app['custom_templating']->load('customer', $slug);

    $app['custom_mailer']->send(
        $template,
        array('data' => $app['request']->request->all()),
        array('foo@email.it')
    );

    return $app->json(array('success' => true));
});

return $app;
