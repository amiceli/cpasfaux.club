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

//vérification du serveur
$serveur = $_SERVER['HTTP_HOST'];
$prod = [
    'driver'    => 'pdo_mysql',
    'host'      => 'localhost',
    'dbname'    => 'cpasfaux',
    'user'      => 'root',
    'password'  => 'toni',
    'charset'   => 'utf8',
];
$localhost = [
    'driver'    => 'pdo_mysql',
    'host'      => 'localhost',
    'dbname'    => 'cpasfaux',
    'user'      => 'root',
    'password'  => 'toni',
    'charset'   => 'utf8',
];
$dbOption = ($serveur != 'localhost') ? ['db.options' => $prod,] : ['db.options' => $localhost,];
//  Data access layer provider
$app->register(new Silex\Provider\DoctrineServiceProvider(), $dbOption);

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

            $perso = utf8_encode(trim($element[0]));
            $livre = trim($element[1]);
            $content = utf8_encode(str_replace('.mp3', '', trim($element[2])));

            $perso = utf8_decode($perso);

            //on récupère les informations sur le personnage
            $queryPersosJukebox = '
                SELECT 
                nom, 
                acteur,
                profil 
                FROM personnage
                WHERE nom = "'.$perso.'"
                ORDER BY nom ASC;
            ';
            $resultPersosJukebox = $app['db']->query($queryPersosJukebox);
            $allPersosJukebox = $resultPersosJukebox->fetchAll(PDO::FETCH_CLASS);


            //on crée un tableau récupérant les audios correspondant à un personnage
            //avec ses informations
            if (!array_key_exists($perso, $jukeboxes)) {
                $jukeboxes[$perso] = [
                    'acteur' => $allPersosJukebox[0]->acteur,
                    'profil' => $allPersosJukebox[0]->profil,
                    'livres' => [],
                ];
            }

            if (!array_key_exists($livre, $jukeboxes[$perso])) {
                $jukeboxes[$perso]['livres'][$livre] = [];
            }

            $jukeboxes[$perso]['livres'][$livre][] = [
                'content' => $content,
                'path' => utf8_encode($each),
            ]; 
        }
    }

    return $app['twig']->render('pages/jukebox.html.twig', array(
        'jukeboxes' => $jukeboxes
    ));
})->bind('jukebox');

$app->get('/citations', function() use($app) {

    //  GET citations
    $queryAllCitations = '
        SELECT 
        ci.content, 
        ci.episode, 
        pe.nom AS "personnage", 
        pe.acteur,
        pe.profil,
        li.nom AS "livre" 
        FROM citation ci, 
        personnage pe, 
        livre li 
        WHERE ci.idLivre = li.id 
        AND ci.idPersonnage = pe.id
        ORDER BY pe.nom ASC;
    ';
    $resultAllCitations = $app['db']->query($queryAllCitations);
    $allCitations = $resultAllCitations->fetchAll(PDO::FETCH_CLASS);
    $personnages = []; 
    foreach ($allCitations as $each) {        
        if(!array_key_exists($each->personnage, $personnages)){
            $personnages[$each->personnage] = [
                'acteur' => $each->acteur,
                'profil' => $each->profil,
                'livres' => [],
            ];            
        }
        if(!array_key_exists($each->livre, $personnages[$each->personnage]['livres'])){
            $personnages[$each->personnage]['livres'][$each->livre] = [
                'cite' => [],
            ];
        }    
        $personnages[$each->personnage]['livres'][$each->livre]['cite'][] = 
        '"<span class="sansBold">'.$each->content.'</span>"<br>'.$each->episode.'<br>';      
    }

    return $app['twig']->render('pages/citations.html.twig', array(
        'citations' => $personnages
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
