<?php
namespace Application\Model\Comment;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Comment 
{
    public string $identifier;
    public string $author;
    public string $comment;
    public string $comment_date;
    public string $post;
}

class CommentRepository {

    public DatabaseConnection $connection;

    public function getComments(string $post):array
    {

        $statement = $this->connection->getConnection()->prepare( "SELECT id, author,post_id, comment, DATE_FORMAT(date_comment, '%/d/%m/%Y à %Hh%imin%ss') AS comment_date_french FROM comments WHERE post_id = ? ORDER BY date_comment DESC ");
        $statement->execute([$post]);

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->identifier = $row['id'];
            $comment->author = $row['author'];
            $comment->comment = $row['comment'];
            $comment->comment_date = $row['comment_date_french'];
            $comment->post = $row['post_id'];
            $comments[] = $comment;
        }
        return $comments;
    }

    public function getComment(string $identifier) : ?Comment
    {
        $statement = $this->connection->getConnection()->prepare( "SELECT id, author,post_id, comment, DATE_FORMAT(date_comment, '%/d/%m/%Y à %Hh%imin%ss') AS comment_date_french FROM comments WHERE id = ? ");
        $statement->execute([$identifier]);
        
        $row = $statement->fetch();
        if ($row === false) {
            return null;
        }

        $comment = new Comment();
        $comment->identifier = $row['id'];
        $comment->author = $row['author'];
        $comment->comment = $row['comment'];
        $comment->comment_date = $row['comment_date_french'];
        $comment->post = $row['post_id'];
        
        
        return $comment;
    }

    public function createComment(string $post, string $author, string $comment) : bool
    {

    $statement = $this->connection->getConnection()->prepare('INSERT INTO comments(post_id,author,comment, date_comment) VALUES(?, ?, ?, NOW())');
    $affectedLines = $statement->execute([$post, $author, $comment]);

    return ($affectedLines > 0);
    }

    public function updateComment(string $identifier, string $author, string $comment ) : bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'UPDATE comments SET author = ?, comment = ? WHERE id = ?'
        );
        $affectedLines = $statement->execute([$author, $comment, $identifier]);

        return ($affectedLines > 0);
    }

}