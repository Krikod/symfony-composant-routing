<?php

/**
 * BIENVENUE DANS CE COURS SUR LE COMPOSANT SYMFONY/ROUTING !
 * ----------------------
 * Dans ce cours nous allons étudier ce fabuleux composant qui permet de créer et de gérer des routes (adresses) intelligentes et intelligibles !
 * 
 * PRESENTATION DE L'APPLICATION (SIMPLE) :
 * ----------------
 * Nous avons ici une application de gestion de tâches très simple : pas de base de données, pas de réelles manipulations de données, ce n'est
 * qu'à des fins d'exemples.
 * 
 * Elle possède 3 pages distinctes :
 * - /index.php (ou /index.php?page=list) : permet d'afficher la liste des tâches contenue dans le fichier data.php (voir le fichier pages/list.html.php)
 * - /index.php?page=show&id=100 : permet d'afficher la tâche dont l'identifiant est 100 en détails (voir le fichier pages/show.html.php)
 * - /index.php?page=create (en GET) : permet d'afficher le formulaire de création (voir le fichier pages/create.html.php)
 * - /index.php?page=create (en POST) : permet de traiter le formulaire de création (toujours dans pages/create.html.php)
 * 
 * CREER DES ROUTES PERSONNALISEES (ET JOLIES ?) :
 * ----------------
 * On souhaite désormais pouvoir gérer tout ça avec des routes plus "propres" :
 * - /index.php (ou /index.php?page=list) deviendrait juste / 
 * - /index.php?page=show&id=100 deviendrait /show/100
 * - /index.php?page=create (en GET) deviendrait /create (en GET)
 * - /index.php?page=create (en POST) deviendrait /create (en POST)
 * 
 * Ca vous dit ? Alors commencez par bien analayser l'application dans son état actuel pour bien la comprendre, et passez à la section suivante
 * 
 */

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use App\Controller\HelloController;
use App\Controller\TaskController;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

require __DIR__ . '/vendor/autoload.php';
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

//$loader = new PhpFileLoader(new FileLocator(__DIR__. '/config'));
//$collection = $loader->load('routes.php');

$loader = new YamlFileLoader(new FileLocator(__DIR__. '/config'));
$collection = $loader->load('routes.yaml');

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

try {
	$currentRoute = $matcher->match($pathInfo);
//dd( $currentRoute);
	$controller = $currentRoute['_controller']; // Callable

	$currentRoute['generator'] = $generator;

	$className = substr($controller, 0, strpos($controller, '@'));
	$methodName = substr($controller, strpos($controller, '@') + 1);

	$instance = new $className();

	call_user_func([$instance, $methodName], $currentRoute);
//	PAREIL == $instance->$methodName($currentRoute);

} catch (ResourceNotFoundException $e) {
		require 'pages/404.html.php';
	    return;
};


/**
 * LES PAGES DISPONIBLES
 * ---------
 * Afin de pouvoir être sur que le visiteur souhaite voir une page existante, on maintient ici une liste des pages existantes
 */
//$availablePages =  [
//    'list', 'show', 'create'
//];

// Par défaut, la page qu'on voudra voir si on ne précise pas (par exemple sur /index.php) sera "list"
//$page = 'list';

// Si on nous envoi une page en GET, on la prend en compte (exemple : /index.php?page=create)
//if (isset($_GET['page'])) {
//    $page = $_GET['page'];
//}

// Si la page demandée n'existe pas (n'est pas dans le tableau $availablePages)
// On affiche la page 404
//if (!in_array($page, $availablePages)) {
//    require 'pages/404.html.php';
//    return;
//}

/**
 * ❌ ATTENTION DEMANDEE !
 * -----------
 * Ici, un moyen simple d'obeir au visiteur et de lui présenter ce qu'il demande c'est d'inclure le fichier qui porte le même nom que la 
 * variable $page. 
 * 
 * => EXTREMENT DANGEREUX ! Ca veut dire que le visiteur pilote l'inclusion de scripts PHP, quelqu'un de malin pourrait s'en servir pour inclure 
 * un script non prévu ou voulu. On est un peu protégé par la condition juste au dessus, mais c'est quand même HYPER LIMITE.
 * 
 * Comment allons nous réparer ça dans les prochaines sections ?
 * 
 * ❌ AUTRE PROBLEME DE TAILLE ICI : LE COUPLAGE DE L'URL ET DES NOMS DE FICHIERS
 * ------------
 * Le fichier que l'on va inclure porte le même nom que le paramètre $_GET['page']. C'est à dire que si on appelle /index.php?page=create
 * c'est le fichier pages/create.html.php qui va être inclus.
 * 
 * La conséquence, c'est que si demain je décide que le formulaire de création devrait se trouver sur /index.php?page=new il faudra que je
 * renomme forcément le fichier pages/create.html.php en pages/new.php et inversement (l'enfer)
 */
//require_once "pages/$page.php";
