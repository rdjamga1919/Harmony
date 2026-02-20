<?php

require_once(__DIR__ . '/../config.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="connexion.css">
</head>
<body>
<?php include '../source/inclue/header.php'?>
<h2>Connexion</h2>

<form action="traitement.html" method="post">
    <label for="email">Adresse e-mail :</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Se connecter">
</form>
<?php include '../source/inclue/footer.php'?>
</body>
</html>

