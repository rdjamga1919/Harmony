<?php
require_once(__DIR__ . '/../../source/fonctions/authentification.php');

if (!estAdmin()) {
    header('Location: /Harmony/public/connexion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Accueil</title>
</head>
<body>
<h1>Tableau de bord admin</h1>
</body>
</html>