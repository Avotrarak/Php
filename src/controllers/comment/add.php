<?php

namespace Application\Controllers\Comment\Add;

//src/controllers/add_comment.php

require_once('src/lib/database.php');
require_once('src/model/comment.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Comment\CommentRepository;

class AddComment 
{
    public function execute(string $post, array $input)
    {
        $author = null;
        $comment = null;
    
        if (!empty($input['author']) && !empty($input['comment'])) {
            $author = $input['author'];
            $comment = $input['comment'];
        } else {
            die('Les données du formulaire sont invalides.');
        }

        $commentRepository = new CommentRepository();
        $commentRepository->connection = new DatabaseConnection();
        $success = $commentRepository->createComment($post, $author, $comment);
        if (!$success) {
            die('Impossible d\ajouter le commentaire !');
        } else {
            header('Location: index.php?action=post&id=' . $post);
        }

    }
}





