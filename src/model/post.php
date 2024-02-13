<?php 

namespace Application\Model\Post;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Posts
{
    public string $title;
    public string $creation_date;
    public string $content;
    public string $identifier;
}

class PostRepository
{
    public DatabaseConnection $connection;

    public function getPost(string $identifier): Posts {
        
        $statement = $this->connection->getConnection()->prepare("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS  french_creation_date FROM billets WHERE id = ?");
        $statement->execute([$identifier]);
    
        $row = $statement->fetch();
        $post = new Posts();
        $post->title = $row['titre'];
        $post->creation_date = $row['french_creation_date'];
        $post->content = $row['contenu'];
        $post->identifier = $row['id'];
        
        return $post;
    }

    public function getPosts(): array {

	$statement = $this->connection->getConnection()->query("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS  french_creation_date FROM billets ORDER BY date_creation DESC LIMIT 0, 5");

	$posts = [];
	while (($row = $statement->fetch())) {
        $post = new Posts();
		$post->title = $row['titre'];
        $post->creation_date = $row['french_creation_date'];
		$post->content = $row['contenu'];
		$post->identifier = $row['id'];

		

	$posts[] = $post;
	}
	
	return $posts;
	
}

}
