<?php $title = "Le blog de l'AVBN"; ?>

<?php ob_start(); ?>
<h1>Le super blog de l'AVBN !</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        <?= htmlspecialchars($post->title) ?>
        <em>le <?= $post->creation_date; ?></em>
    </h3>
    <p>
        <?= nl2br(htmlspecialchars($post->content)) ?>
    </p>
</div>

<h2>Commentaires</h2>
<fieldset>
	<legend>Ajouter un commentaire</legend>
<div class="exe">
<form action="index.php?action=addComment&id=<?= $post->identifier ?>" method="post">
   <div class="form">
      <label for="author">Auteur</label><br />
      <input type="text" id="author" name="author" />
   </div>
   <div class="form">
      <label for="comment">Commentaire</label><br />
      <textarea id="comment" name="comment"></textarea>
   </div>
   <div clas="form">
      <input type="submit" value="Envoyer" />
   </div>
</form>
</div>
</fieldset>

<h2>Liste des commentaires</h2>
<?php
foreach ($comments as $comment) {
?>
	<div class="news">
	
    <p><strong><?= htmlspecialchars($comment->author) ?></strong> le <?= $comment->comment_date; ?> 
    <a href="index.php?action=updateComment&id=<?= urlencode($comment->identifier) ?>">(modifier)</a></p>
    <p><?= nl2br(htmlspecialchars($comment->comment)) ?></p>
	</div>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
