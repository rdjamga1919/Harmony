<?php
session_start();

require_once(__DIR__ . '/../../config.php');
require_once(ROOT . '/source/fonctions/authentification.php');
require_once(ROOT . '/source/fonctions/utilisateur.php');

exigerConnexion();

$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erreurs'] = ["Méthode non autorisée."];
    header('Location: ' . BASE_URL . '/public/profil.php');
    exit;
}

$idUtilisateur = (int) $_SESSION['id_utilisateur'];

if (!utilisateurPeutChangerMotDePasse($pdo, $idUtilisateur)) {
    $_SESSION['erreurs'] = ["Vous n'êtes pas autorisé à modifier votre mot de passe."];
    header('Location: ' . BASE_URL . '/public/profil.php');
    exit;
}

$motDePasseActuel = $_POST['mot_de_passe_actuel'] ?? '';
$nouveauMotDePasse = $_POST['nouveau_mot_de_passe'] ?? '';
$confirmationMotDePasse = $_POST['confirmation_mot_de_passe'] ?? '';

$erreurs = [];

if ($motDePasseActuel === '' || $nouveauMotDePasse === '' || $confirmationMotDePasse === '') {
    $erreurs[] = "Tous les champs sont obligatoires.";
}

if ($nouveauMotDePasse !== $confirmationMotDePasse) {
    $erreurs[] = "La confirmation du nouveau mot de passe ne correspond pas.";
}

if (mb_strlen($nouveauMotDePasse) < 8) {
    $erreurs[] = "Le nouveau mot de passe doit contenir au moins 8 caractères.";
}

$regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};:\'",.<>\/?\\\\|`~]).{8,}$/';

if ($nouveauMotDePasse !== '' && !preg_match($regex, $nouveauMotDePasse)) {
    $erreurs[] = "Le nouveau mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.";
}

if (empty($erreurs)) {
    try {
        $motDePasseHashActuel = recupererMotDePasseHashUtilisateur($pdo, $idUtilisateur);

        if (!$motDePasseHashActuel) {
            $erreurs[] = "Utilisateur introuvable.";
        } elseif (!password_verify($motDePasseActuel, $motDePasseHashActuel)) {
            $erreurs[] = "Le mot de passe actuel est incorrect.";
        } else {
            $nouveauHash = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);
            $succes = modifierMotDePasseUtilisateur($pdo, $idUtilisateur, $nouveauHash);

            if ($succes) {
                $_SESSION['succes'] = "Votre mot de passe a été modifié avec succès.";
            } else {
                $_SESSION['erreurs'] = ["Impossible de modifier le mot de passe."];
                header('Location: ' . BASE_URL . '/public/profil.php');
                exit;
            }
        }
    } catch (PDOException $e) {
        error_log("Erreur modification mot de passe : " . $e->getMessage());
        $_SESSION['erreurs'] = ["Une erreur est survenue lors de la modification du mot de passe."];
        header('Location: ' . BASE_URL . '/public/profil.php');
        exit;
    }
}

if (!empty($erreurs)) {
    $_SESSION['erreurs'] = $erreurs;
}

header('Location: ' . BASE_URL . '/public/profil.php');
exit;