<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class HelloController {
	/**
	 * @Route("hello/{name}", name="hello", defaults={"name"="world"})
	 */
	public function sayHello(array $currentRoute) {
//		dump( $currentRoute);

		require __DIR__ . '/../../pages/hello.html.php';


	}
}