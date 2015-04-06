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

//  Data access layer provider
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(

        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'cpasfaux',
        'user'      => 'root',
        'password'  => 'alexmercer',
        'charset'   => 'utf8',

    ),
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
})->bind('home');

$app->get('/jukebox', function() use($app) {

    $files = scandir(__DIR__ . '/public/songs');

    $jukeboxes = [];

    foreach ($files as $each) {
        if ($each != '.' && $each != '..') {

            $element = explode('-', $each);

            $perso = trim($element[0]);
            $livre = trim($element[1]);
            $content = str_replace('.mp3', '', trim($element[2]));

            if (!array_key_exists($perso, $jukeboxes)) {
                $jukeboxes[$perso] = [];
            }

            if (!array_key_exists($livre, $jukeboxes[$perso])) {
                $jukeboxes[$perso][$livre] = [];
            }

            array_push($jukeboxes[$perso][$livre], array(
               'content' => $content,
                'path' => $each
            ));

        }
    }

    return $app['twig']->render('pages/jukebox.html.twig', array(
        'jukeboxes' => $jukeboxes
    ));
})->bind('jukebox');

$app->get('/citations', function() use($app) {

    //  GET citations
    $allCitations = $app['db']->fetchAll('SELECT ci.content, ci.episode, pe.nom as "personnage", li.nom FROM citation ci, personnage pe, livre li WHERE ci.idLivre = li.id AND ci.idPersonnage = pe.id;');
    $arr = [];

    foreach ($allCitations as $each) {

        if (!array_key_exists($each['personnage'], $arr)) {
            $arr[ $each['personnage'] ] = [];
        }

        $each['nom'] = ucfirst($each['nom']);

        if (!array_key_exists($each['nom'], $arr[ $each['personnage'] ])) {
            $arr[ $each['personnage'] ][ $each['nom'] ] = [];
        }

        $idx = $each['personnage'];
        
        array_push($arr[ $each['personnage'] ][ $each['nom'] ], array(
            "content" => $each['content'],
            "episode" => $each['episode']
        ));
    }

    /*echo '<pre>';
        print_r($arr);
    echo '<pre>';*/

    return $app['twig']->render('pages/citations.html.twig', array(
        'citations' => $arr
    ));
})->bind('citations');

$app->get('/apropos', function() use($app) {
    return $app['twig']->render('pages/about.html.twig');
})->bind('about');

$app->get('/contact', function(Symfony\Component\HttpFoundation\Request $request) use($app) {

    //  Form create with form provider
    $form = $app['form.factory']->createBuilder('form')
        ->add('name', 'text', array(
            "label" => 'Nom'
        ))
        ->add('firstname', 'text', array(
            'label' => 'Prénom'
        ))
        ->add('email', 'email', array(
            'label' => 'Email'
        ))
        ->add('object', 'text', array(
            'label' => 'objet'
        ))
        ->add('message', 'textarea', array(
            'label' => 'Message'
        ))
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
