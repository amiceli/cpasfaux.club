<?php

require_once __DIR__.'/vendor/autoload.php'; 

$app = new Silex\Application(); 

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->get('/', function() use($app) { 
    return $app['twig']->render('pages/index.html.twig');
}); 

$app->get('/jukebox', function() use($app) { 
    return $app['twig']->render('pages/jukebox.html.twig');
}); 

$app->run();