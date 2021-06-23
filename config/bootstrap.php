<?php

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Config\FileLocator;
use App\Loader\CustomAnnotationClassLoader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;

require __DIR__ . '/../vendor/autoload.php';
//
//$controller = new HelloController;
//$controller->sayHello();
//die();

//$callable = [new HelloController, 'sayHello'];

//$helloRoute = new Route(
//	'/hello/{name}',
////	['name' => 'world', 'toto' => 42],
//	['name' => 'world', 'controller' => 'App\Controller\HelloController@sayHello']
////	['name' => '.{3}']
//	);

//call_user_func($callable);

//$listRoute = new Route('/', ['controller' => 'App\Controller\TaskController@index']);
//$createRoute = new Route( '/create', ['controller' => 'App\Controller\TaskController@create'], [], [], 'localhost', ['http'], ['POST', 'GET'] );
//$showRoute = new Route( '/show/{id}', [], ['id' => '\d+']);
//$showRoute = new Route( '/show/{id<\d+>?100}',	['controller' => 'App\Controller\TaskController@show']
//	);

//$collection = new RouteCollection();

//Loader PHP
//$loader = new PhpFileLoader(new FileLocator(__DIR__. '/config'));
//$collection = $loader->load('routes.php');

//Loader Yaml
//$loader = new YamlFileLoader(new FileLocator(__DIR__. '/config'));
//$collection = $loader->load('routes.yaml');

//Loader Annotations
$classLoader = require __DIR__.'/../vendor/autoload.php';
AnnotationRegistry::registerLoader([$classLoader, 'loadClass']);

$loader = new AnnotationDirectoryLoader(
new FileLocator(__DIR__.'/../src/Controller'),
new CustomAnnotationClassLoader(new AnnotationReader())
);
$collection = $loader->load(__DIR__.'/../src/Controller');

//$collection->add('list', $listRoute);
//$collection->add('create', $createRoute);
//$collection->add('show', $showRoute);
//$collection->add( 'hello', $helloRoute);

//dump( $_SERVER);

$matcher = new UrlMatcher($collection, new RequestContext('', $_SERVER['REQUEST_METHOD']));
$generator = new UrlGenerator($collection, new RequestContext());

//dd($generator->generate('show', ['id' => 100]));
//dd($generator->generate('create'));

//$resultat = $matcher->match( '/show/100');
//dd($resultat);

//var_dump( $_SERVER);

// S'il n'y a rien là-dedans, on est dans /:
$pathInfo = $_SERVER['PATH_INFO'] ?? '/';