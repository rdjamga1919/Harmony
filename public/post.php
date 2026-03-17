<?php require_once(__DIR__ . '/../source/bdd/connexion_bdd_jordan.php'); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer un post</title>
    <link rel="stylesheet" href="../ressources/css/forum.css">
</head>

<body>

<?php include '../source/inclue/header.php'; ?>

<h2>Créer un post</h2>

<form action="../traitement/traitement_post.php" method="POST">

    <label for="titre">Titre</label><br>
    <input type="text" name="titre" id="titre" required>

    <br><br>

    <label for="contenu">Message</label><br>
    <textarea name="contenu" id="contenu" rows="6" required></textarea>

    <button type="submit">PUBLIER</button>

</form>

<div class="btn-wrapper-center">
    <a href="forum.php" class="btn-retour">Retour au forum</a>
</div>

</body>
</html>