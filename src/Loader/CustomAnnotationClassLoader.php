<?php

namespace App\Loader;

use Symfony\Component\Routing\Loader\AnnotationClassLoader;
use Symfony\Component\Routing\Route;

class CustomAnnotationClassLoader extends AnnotationClassLoader {

	protected function configureRoute( Route $route, \ReflectionClass $class, \ReflectionMethod $method, object $annot ) {
		// TODO: Implement configureRoute() method.
		$route->addDefaults([
			'_controller' => $class->name . '@' . $method->name
		]);
//		dd( $route, $class, $method, $annot);
	}
}