<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function(RoutingConfigurator $configurator) {
	$configurator
		// On peut virer les controlleurs des Defaults.
		->add('hello', '/hello/{name}')
		->defaults([
			'name' => 'world'
		])
		->controller('App\Controller\HelloController@sayHello')

		->add('list', '/')
		->defaults(['controller' => 'App\Controller\TaskController@index'
		])

		->add('create', '/create')
		->defaults(['controller' => 'App\Controller\TaskController@create'])
		->host('localhost')
		->schemes(['http'])
		->methods(['POST', 'GET'])

		->add('show', '/show/{id}')
		->defaults(['id' => 100, 'controller' => 'App\Controller\TaskController@show'])
		->requirements(['id' => '\d+'])
	;
};