<?php
session_start();
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../source/fonctions/authentification.php');
require_once (__DIR__ . '/../source/fonctions/utilisateur.php');

exigerConnexion();
$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');


$idUtilisateur = (int) $_SESSION['id_utilisateur'];
$utilisateur = recupererUtilisateurParId($pdo, $idUtilisateur);

if (!$utilisateur) {
    $_SESSION['erreurs'] = ["Utilisateur introuvable."];
    header('Location: ' . BASE_URL . '/public/forum.php');
    exit;
}
function e(?string $valeur): string
{
    return htmlspecialchars($valeur ?? '', ENT_QUOTES, 'UTF-8');
}

$erreurs = $_SESSION['erreurs'] ?? [];
$succes = $_SESSION['succes'] ?? []; //ou null
$valeurs = $_SESSION['valeurs'] ?? [];

unset($_SESSION['erreurs'], $_SESSION['succes'], $_SESSION['valeurs']);

$pseudo = $valeurs['pseudo'] ?? $utilisateur['pseudo'];
$nom = $valeurs['nom'] ?? $utilisateur['nom'];
$prenom = $valeurs['prenom'] ?? $utilisateur['prenom'];
$email = $valeurs['email'] ?? $utilisateur['email'];
$niveauEtudes = $valeurs['niveau_etudes'] ?? $utilisateur['niveau_etudes'];
$typeEtudes = $valeurs['type_etudes'] ?? $utilisateur['type_etudes'];
// a quoi sert la partie ci dessus et est ce qu'on peut rajouter une requetes fetch data from bdd pour afficher le profil avant de modifier
$peutChangerMdp = utilisateurPeutChangerMotDePasse($pdo, $idUtilisateur);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil</title>
    <!--
    <link rel="stylesheet" href="<//?= BASE_URL ?>/ressources/css/style.css">
    -->
</head>
<body>

<?php require_once ROOT . '/source/inclue/header.php'; ?>

<main class="conteneur">
    <section class="bloc-profil">
        <h1>Mon profil</h1>
        <section class="bloc-formulaire">
            <h2>Mes informations actuelles</h2>
            <p><strong>Pseudo :</strong> <?= e($utilisateur['pseudo'] ?: 'Non renseigné') ?></p>
            <p><strong>Nom :</strong> <?= e($utilisateur['nom']?: 'Non renseigné') ?></p>
            <p><strong>Prénom :</strong> <?= e($utilisateur['prenom'] ?: 'Non renseigné') ?></p>
            <p><strong>Email :</strong> <?= e($utilisateur['email'] ?: 'Non renseigné') ?></p>
            <p><strong>Niveau d'études :</strong> <?= e($utilisateur['niveau_etudes'] ?: 'Non renseigné') ?></p>
            <p><strong>Type d'études :</strong> <?= e($utilisateur['type_etudes'] ?: 'Non renseigné') ?></p>
        </section>
        <p>Vous pouvez modifier vos informations personnelles.</p>


        <?php if (!empty($erreurs)) : ?>
            <div class="message-erreur">
                <ul>
                    <?php foreach ($erreurs as $erreur) : ?>
                        <li><?= e($erreur) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($succes): ?>
            <div class="message-succes">
                <p><?= e($succes) ?></p>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/traitement/utilisateur/traiter_profil.php" method="POST">
            <fieldset>
                <legend>Informations du compte</legend>

                <div>
                    <label for="pseudo">Pseudo</label>
                    <input type="text" id="pseudo" name="pseudo" value="<?= e($pseudo) ?>" required>
                </div>

                <div>
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?= e($nom) ?>">
                </div>

                <div>
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="<?= e($prenom) ?>">
                </div>

                <div>
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" value="<?= e($email) ?>" required>
                </div>

                <div>
                    <label for="niveau_etudes">Niveau d'études</label>
                    <input
                            type="text"
                            id="niveau_etudes"
                            name="niveau_etudes"
                            value="<?= e($niveauEtudes) ?>"
                            placeholder="Ex : BTS SIO 1re année"
                    >
                </div>

                <div>
                    <label for="type_etudes">Type d'études</label>
                    <input
                            type="text"
                            id="type_etudes"
                            name="type_etudes"
                            value="<?= e($typeEtudes) ?>"
                            placeholder="Ex : BTS SIO SLAM"
                    >
                </div>

                <div>
                    <button type="submit">Enregistrer les modifications</button>
                </div>
            </fieldset>
        </form>
    </section>

    <section class="bloc-profil">
        <h2>Mot de passe</h2>

        <?php if ($peutChangerMdp) : ?>
            <form action="<?= BASE_URL ?>/traitement/utilisateur/traiter_mot_de_passe.php" method="POST">
                <fieldset>
                    <legend>Sécurité</legend>

                    <div>
                        <label for="mot_de_passe_actuel">Mot de passe actuel</label>
                        <input type="password" id="mot_de_passe_actuel" name="mot_de_passe_actuel" required>
                    </div>

                    <div>
                        <label for="nouveau_mot_de_passe">Nouveau mot de passe</label>
                        <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" required minlength="8">
                    </div>

                    <div>
                        <label for="confirmation_mot_de_passe">Confirmer le nouveau mot de passe</label>
                        <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required minlength="8">
                    </div>

                    <div>
                        <button type="submit">Modifier le mot de passe</button>
                    </div>
                </fieldset>
            </form>
        <?php else : ?>
        <div class="message-erreur">
        <p>La modification du mot de passe est désactivée pour ce compte.</p>
        </div>
        <?php endif; ?>
    </section>
</main>

<?php require_once ROOT . '/source/inclue/footer.php'; ?>

</body>
</html>
