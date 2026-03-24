<?php
session_start();
require_once(__DIR__ . '/../source/bdd/connexion_bdd_jordan.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: connexion.php?redirect=forum');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: forum.php');
    exit();
}

$id_poste = (int)$_GET['id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un commentaire</title>
    <link rel="stylesheet" href="../ressources/css/forum.css">
</head>
<body>

<h2>Ajouter un commentaire</h2>

<form action="../traitement/traitement_commentaire.php" method="POST">
    <input type="hidden" name="id_poste" value="<?php echo $id_poste; ?>">
    <label for="contenu">Commentaire</label><br>
    <textarea name="contenu" id="contenu" rows="6" required></textarea>
    <button type="submit">PUBLIER</button>
</form>

<div class="btn-wrapper-center">
    <a href="detail_post.php?id=<?php echo $id_poste; ?>" class="btn-retour">Retour au post</a>
</div>

</body>
</html>