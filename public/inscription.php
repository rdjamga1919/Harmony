<?php
session_start();

$erreurs = $_SESSION['erreurs'] ?? [];
$valeurs = $_SESSION['valeurs'] ?? [];

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
    <title>Inscription sur Harmony</title>
    <link rel="stylesheet" href="../ressources/css/forum.css">
</head>
<body>

<h2>Créer un compte</h2>

<?php if (!empty($erreurs)): ?>
    <div>
        <ul>
            <?php foreach ($erreurs as $erreur): ?>
                <li><?= e($erreur) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="../traitement/traitement_inscription.php" method="post" novalidate>
    <fieldset>
        <legend>Inscription</legend>

        <div>
            <label for="pseudo">Pseudo :</label>
            <input type="text" id="pseudo" name="pseudo" required
                   value="<?= e($valeurs['pseudo'] ?? '') ?>">
        </div>

        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required
                   value="<?= e($valeurs['email'] ?? '') ?>">
        </div>

        <div>
            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" required>
        </div>

        <div>
            <label for="mdp_confirm">Confirmer le mot de passe :</label>
            <input type="password" id="mdp_confirm" name="mdp_confirm" required>
        </div>

        <div>
            <button type="submit">S'inscrire</button>
            <p>Déjà un compte ? <a href="connexion.php">Connectez-vous ici</a></p>
        </div>

    </fieldset>
</form>

</body>
</html>