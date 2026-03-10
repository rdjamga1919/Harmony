<?php

require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../source/fonctions/authentification.php');
//exigerConnexion();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus bien-être</title>
    <link rel="stylesheet" href="forum.css">
</head>
<body>
<?php include '../source/inclue/header.php'?>
<h2>Posts </h2>

<!-- Zone où les posts devraient apparaître -->
<div>

</div>
<h3>Ajouter un nouveau post</h3>

<form action="" method="post">
    <label for="content">Contenu du post </label><br>
    <textarea id="content" name="content" rows="4" cols="50"></textarea><br><br>
    <button type="submit">Publier</button>
</form>
<?php include '../source/inclue/footer.php'?>
</body>
</html>