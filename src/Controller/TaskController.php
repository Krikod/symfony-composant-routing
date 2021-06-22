<?php

namespace App\Controller;

class TaskController {
	// Lister, montrer, ajouter

	public function index(array $currentRoute) {
//		dd( 'index de la liste des tâches');
		$generator = $currentRoute['generator'];

		require __DIR__.'/../../pages/list.php';

	}

	public function show(array $currentRoute) {
//		dd( "affichage d'une tâche");

		$generator = $currentRoute['generator'];
		require __DIR__.'/../../pages/show.php';

	}

	public function create(array $currentRoute) {
//		dd( "création d'une tâche");

		$generator = $currentRoute['generator'];
		require __DIR__.'/../../pages/create.php';


	}
}