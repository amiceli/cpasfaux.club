<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->before(function () use ($app) {

    $files = array_diff(scandir(__DIR__ . '/public/img/slider'), array('.', '..'));
    $returnedFiled = [];

    foreach ($files as $each) {
        array_push($returnedFiled, [
            "filename" => $each,
            "alt" => preg_replace('/\\.[^.\\s]{3,4}$/', '', $each)
        ]);
    }

    $app['twig']->addGlobal('images', $returnedFiled);
});

$app->get('/', function() use($app) {
    return $app['twig']->render('pages/index.html.twig');
});

$app->get('/jukebox', function() use($app) {
    return $app['twig']->render('pages/jukebox.html.twig');
});

$app->run();
