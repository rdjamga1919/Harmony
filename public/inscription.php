
<?php
session_start();
require_once(__DIR__ . '/../config.php');

$erreurs = $_SESSION['erreurs'] ?? [];
$valeurs = $_SESSION['valeurs'] ?? ['pseudo' => '', 'email' => ''];
$succes  = $_SESSION['succes'] ?? null;



if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

// Nettoyage des messages en session (pour éviter qu'ils restent)
unset($_SESSION['erreurs'], $_SESSION['valeurs'], $_SESSION['succes']);
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>S'inscrire sur Harmony</title>
</head>
<body>
<h2>Page d'inscription</h2>

<?php if ($succes): ?>
<!--ici je veux plutot lié la page css dedicacé et uniformiser pour tous-->
<?php endif; ?>

<?php if (!empty($erreurs)): ?>
    <div >
        <p>Veuillez corriger les erreurs suivantes :</p>
        <ul>
            <?php foreach ($erreurs as $msg): ?>
                <li><?= e($msg) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form action="../traitement/traitement_inscription.php" method="post"  novalidate>
    <fieldset>
        <legend>Inscription</legend>
        <div>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['token'] ?>">
        </div>
        <div>
            <label for="pseudo">Votre pseudo </label>
            <input type="text" name="pseudo" id="pseudo" required
                   minlength="5" 
                   value="<?= e($valeurs['pseudo'] ?? '') ?>" 
            > <!--utilisation du html specialchars-->
        <?php if (isset($erreurs['pseudo'])): ?>
            <p><?= e($erreurs['pseudo']) ?></p>
        <?php endif; ?>
        </div>

        <div>
            <label for="email"> Votre Email</label>
            <input type="email" name="email" id="email" required
                   value="<?= e($valeurs['email'] ?? '') ?>">
            <?php if (isset($erreurs['email'])): ?>
                <p><?= e($erreurs['email']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="pass"> Votre mot de passe </label>
            <input type="password" name="password" id="pass" required
                   minlength="6">
            <?php if (isset($erreurs['mdp'])): ?>
                <p><?= e($erreurs['mdp']) ?></p>
            <?php endif; ?>
        </div>
        <div>
            <label for="passConfirm"> Confirmer votre mot de passe </label>
            <input type="password" name="passwordConfirm" id="passConfirm" required
                   minlength="6">
            <?php if (isset($erreurs['passwordConfirm'])): ?>
                <p><?= e($erreurs['passwordConfirm']) ?></p>
            <?php endif; ?>
        </div>

        <?php if (isset($erreurs['general'])): ?>
            <p><?= e($erreurs['general']) ?></p>
        <?php endif; ?>
        
        <div>
            <button type="submit" >S'inscrire</button>
            <p class="box-register"> Déja inscrit ?
            <a href="connexion.php">Connecter-vous ici</a></p>
        </div>
    </fieldset>
</form>
</body>
</html>

