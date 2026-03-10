<?php

require_once(__DIR__ . '/../config.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST["pseudo"];
    $mot_de_passe = $_POST["mot_de_passe"];
    if ($pseudo === "admin" && $mot_de_passe === "1234") {
        $message = "<p style='color:green;'>Connexion réussie !</p>";
    } else {
        $message = "<p style='color:red;'>Pseudo ou mot de passe incorrect.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>

    <?php echo $message; ?>

    <form method="POST" action="">
        <label>Pseudo :<br>
            <input type="text" name="pseudo" required>
        </label><br><br>
        <label>Mot de passe :<br>
            <input type="password" name="mot_de_passe" required>
        </label><br><br>

        <button type="submit">Se connecter</button>
    </form>

    <p><a href="inscription.php">Pas encore inscrit ?</a></p>
</body>
</html>