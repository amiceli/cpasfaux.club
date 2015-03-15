<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->register(new Silex\Provider\FormServiceProvider());

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider());

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

$app->get('/citations', function() use($app) {
    return $app['twig']->render('pages/citations.html.twig');
})->bind('citations');

$app->get('/apropos', function() use($app) {
    return $app['twig']->render('pages/about.html.twig');
})->bind('about');

$app->get('/contact', function(Symfony\Component\HttpFoundation\Request $request) use($app) {

    //  Form create with form provider
    $form = $app['form.factory']->createBuilder('form')
        ->add('name')
        ->add('firstname')
        ->add('email')
        ->add('object')
        ->add('message', 'textarea')
        ->getForm();

    //  Handle request
    $form->handleRequest($request);

    //  For POST validation
    if ($form->isValid()) {
        //$data = $form->getData();

        // do something with the data

        // redirect somewhere
        return $app->redirect('...');
    }

    return $app['twig']->render('pages/contact.html.twig', array(
        'form' => $form->createView()
    ));

})->bind('contact');

$app->run();
