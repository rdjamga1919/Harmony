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

$pseudo = trim($_POST['pseudo'] ?? '');
$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$niveauEtudes = trim($_POST['niveau_etudes'] ?? '');
$typeEtudes = trim($_POST['type_etudes'] ?? '');

$_SESSION['valeurs'] = [
    'pseudo' => $pseudo,
    'nom' => $nom,
    'prenom' => $prenom,
    'email' => $email,
    'niveau_etudes' => $niveauEtudes,
    'type_etudes' => $typeEtudes
];

$erreurs = [];

if ($pseudo === '') {
    $erreurs[] = "Le pseudo est obligatoire.";
} elseif (mb_strlen($pseudo) < 3) {
    $erreurs[] = "Le pseudo doit contenir au moins 3 caractères.";
} elseif (mb_strlen($pseudo) > 40) {
    $erreurs[] = "Le pseudo ne doit pas dépasser 40 caractères.";
}

if ($nom !== '' && mb_strlen($nom) > 100) {
    $erreurs[] = "Le nom ne doit pas dépasser 100 caractères.";
}

if ($prenom !== '' && mb_strlen($prenom) > 100) {
    $erreurs[] = "Le prénom ne doit pas dépasser 100 caractères.";
}

if ($email === '') {
    $erreurs[] = "L'adresse e-mail est obligatoire.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = "L'adresse e-mail n'est pas valide.";
} elseif (mb_strlen($email) > 255) {
    $erreurs[] = "L'adresse e-mail ne doit pas dépasser 255 caractères.";
}

if ($niveauEtudes !== '' && mb_strlen($niveauEtudes) > 100) {
    $erreurs[] = "Le niveau d'études ne doit pas dépasser 100 caractères.";
}

if ($typeEtudes !== '' && mb_strlen($typeEtudes) > 100) {
    $erreurs[] = "Le type d'études ne doit pas dépasser 100 caractères.";
}

if (empty($erreurs) && pseudoExistePourAutreUtilisateur($pdo, $pseudo, $idUtilisateur)) {
    $erreurs[] = "Ce pseudo est déjà utilisé.";
}

if (empty($erreurs) && emailExistePourAutreUtilisateur($pdo, $email, $idUtilisateur)) {
    $erreurs[] = "Cette adresse e-mail est déjà utilisée.";
}

if (!empty($erreurs)) {
    $_SESSION['erreurs'] = $erreurs;
    header('Location: ' . BASE_URL . '/public/profil.php');
    exit;
}

try {
    $succes = mettreAJourProfilUtilisateur($pdo, $idUtilisateur, [
        'pseudo' => $pseudo,
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'niveau_etudes' => $niveauEtudes,
        'type_etudes' => $typeEtudes
    ]);

    if ($succes) {
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['email'] = $email;
        $_SESSION['succes'] = "Votre profil a été mis à jour avec succès.";
        unset($_SESSION['valeurs']);
    } else {
        $_SESSION['erreurs'] = ["Impossible de mettre à jour votre profil."];
    }
} catch (PDOException $e) {
    error_log("Erreur mise à jour profil : " . $e->getMessage());
    $_SESSION['erreurs'] = ["Une erreur est survenue lors de la mise à jour du profil."];
}

header('Location: ' . BASE_URL . '/public/profil.php');
exit;