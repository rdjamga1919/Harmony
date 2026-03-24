<?php

session_start();
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../source/fonctions/authentification.php');

$erreurs = $_SESSION['erreurs'] ?? [];
$valeurs = $_SESSION['valeurs'] ?? ['identifiant' => ''];

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

$token = $_SESSION['token'];

unset($_SESSION['erreurs'], $_SESSION['valeurs']);

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Se connecter sur Harmony</title>
</head>
<body>
<h2>Page de connexion</h2>
<?php if (!empty($erreurs)): ?>
    <div>
        <ul>
            <?php foreach ($erreurs as $erreur): ?>
                <li><?= e($erreur) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="../traitement/connexion_traitement.php" method="post"  novalidate>
    <fieldset>
        <legend>Connexion</legend>

        <input type="hidden" name="csrf_token" value="<?= e($token) ?>">
        <div>
            <label for="identifiant">Pseudo ou Email :</label>
            <input type="text" id="identifiant" name="identifiant" required
                   autocomplete="username"
                   value="<?= e($valeurs['identifiant'] ?? '') ?>">
        </div>

        <div>
            <label for="pass"> Votre mot de passe </label>
            <input type="password" name="password" autocomplete="current-password" id="pass" required>
        </div>

        <div>
            <button type="submit" >Se connecter</button>
            <p class="box-register"> Vous n'avez pas de compte ?
                <a href="inscription.php">Inscrivez-vous ici</a></p>
        </div>

    </fieldset>
</form>
</body>
</html>