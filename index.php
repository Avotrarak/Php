<?php

require_once('src/controllers/comment/update.php');
require_once('src/controllers/comment/add.php');
require_once('src/controllers/homepage.php');
require_once('src/controllers/post.php');


use Application\Controllers\Comment\Add\AddComment;
use Application\Controllers\Comment\Update\UpdateComment;
use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Post\Posts;


try {
	if (isset($_GET['action']) && $_GET['action'] !== '') {
		if ($_GET['action'] === 'post') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$identifier = $_GET['id'];

				(new Posts())->execute($identifier);
			} else {
				throw new Exception('Aucun identifier de billet envoyé');
			}
		} elseif ($_GET['action'] === 'addComment') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$identifier = $_GET['id'];
			
			 	(new AddComment())->execute($identifier, $_POST);
			} else {
			throw new Exception('Aucun identifiant de billet envoyé');
			}
		} elseif ($_GET['action'] === 'updateComment'){
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$identifier = $_GET['id'];
				
				$input = null;
				if ($_SERVER['REQUEST_METHOD'] === 'POST'){
					$input = $_POST;
				}

				(new UpdateComment())->execute($identifier, $_POST);
			} else {
					throw new Exception('Aucun identifiant de commentaire envoyé');
			}

		} else {
			throw new Exception("La page que vous recherchez n'existe pas.");
		}
	} else {
		(new Homepage())->execute();
	}
} catch (Exception $e) {
	$errorMessage = $e->getMessage();

	require('templates/error.php');
}

