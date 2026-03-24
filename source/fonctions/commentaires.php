<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../source/fonctions/authentification.php');
$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');
$id_poste = filter_input(INPUT_GET, 'id_poste', FILTER_VALIDATE_INT);

if (!$id_poste) {
    header("Location: forum.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Répondre au post</title>
    <link rel="stylesheet" href="forum.css">
</head>
<body>
<?php include '../source/inclue/header.php'; ?>
<h2>Répondre au post #<?= $id_poste ?></h2>
<form action="../traitement/traitement_commentaire.php" method="POST">
    <input type="hidden" name="id_poste" value="<?= $id_poste ?>">
    <label for="contenu">Votre réponse</label>
    <textarea name="contenu" id="contenu" rows="4" required placeholder="Écrivez votre commentaire..."></textarea>
    <button type="submit">ENVOYER</button>
</form>

<div class="btn-wrapper-center">
    <a href="forum.php" class="btn-retour">Retour au forum</a>
</div>

</body>
</html>
$id_poste = filter_input(INPUT_GET, 'id_poste', FILTER_VALIDATE_INT);

if (!$id_poste) {
header("Location: forum.php");
exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Répondre au post</title>
    <link rel="stylesheet" href="forum.css">
</head>
<body>
<?php include '../source/inclue/header.php'; ?>
<h2>Répondre au post #<?= $id_poste ?></h2>
<form action="../traitement/traitement_commentaire.php" method="POST">
    <input type="hidden" name="id_poste" value="<?= $id_poste ?>">
    <label for="contenu">Votre réponse</label>
    <textarea name="contenu" id="contenu" rows="4" required placeholder="Écrivez votre commentaire..."></textarea>
    <button type="submit">ENVOYER</button>
</form>

<div class="btn-wrapper-center">
    <a href="forum.php" class="btn-retour">Retour au forum</a>
</div>

</body>
</html>