<?php

namespace App\Controller;

use Exception;
use Symfony\Component\Routing\Annotation\Route;

class TaskController {
	// Lister, montrer, ajouter

	/**
	 * @Route("/", name="list")
	 */
	public function index(array $currentRoute) {
		$generator = $currentRoute['generator'];
		$data = require_once 'data.php';
		require __DIR__ . '/../../pages/list.html.php';
	}

	/**
	 * @Route("/show/{id}", name="show", requirements={"id"="\d+"})
	 */
	public function show(array $currentRoute) {
		$generator = $currentRoute['generator'];
		$data = require_once "data.php";
		$id = $currentRoute['id'];

		if (!$id || !array_key_exists($id, $data)) {
			throw new Exception("La tâche demandée n'existe pas !");
		}

		$task = $data[$id];
		require __DIR__ . '/../../pages/show.html.php';
	}

	/**
	 * @Route("/create", name="create", host="localhost", schemes={"http", "https"}, methods={"GET", "POST"})
	 */
	public function create(array $currentRoute) {
//		dd( "création d'une tâche");

		$generator = $currentRoute['generator'];
		// Si la requête arrive en POST, c'est qu'on a soumis le formulaire :
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Traitement à la con (enregistrement en base de données, redirection, envoi d'email, etc)...
			var_dump("Bravo, le formulaire est soumis (TODO : traiter les données)", $_POST);

			// Arrêt du script
			return;
		}

		// Sinon, si on est en GET, on affiche :
		require __DIR__ . '/../../pages/create.html.php';


	}
}