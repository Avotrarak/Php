<?php

namespace Application\Controllers\Post;
//controllers/post.php

require_once('src/lib/database.php');
require_once('src/model/post.php');
require_once('src/model/comment.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Comment\CommentRepository;
use Application\Model\Post\PostRepository;

class Posts
{
    public function execute(string $identifier)
    {
        $connection = new DatabaseConnection();

        $postRepository = new PostRepository();
        $postRepository->connection = $connection; 
        $post = $postRepository->getPost($identifier);

        $commentRepository = new CommentRepository();
        $commentRepository->connection = $connection;
        $comments = $commentRepository->getComments($identifier);

        require('templates/post.php');
    }
}