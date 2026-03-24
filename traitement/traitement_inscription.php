<?php
session_start();
require_once(__DIR__ . '/../source/bdd/connexion_bdd_jordan.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/inscription.php');
    exit;
}

$pseudo      = trim($_POST['pseudo'] ?? '');
$email       = trim($_POST['email'] ?? '');
$mdp         = $_POST['mdp'] ?? '';
$mdp_confirm = $_POST['mdp_confirm'] ?? '';

$valeurs = ['pseudo' => $pseudo, 'email' => $email];
$erreurs = [];

if (empty($pseudo) || empty($email) || empty($mdp) || empty($mdp_confirm)) {
    $erreurs[] = "Tous les champs sont obligatoires";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = "Format d'email invalide";
}

if (strlen($mdp) < 8) {
    $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères";
}

if ($mdp !== $mdp_confirm) {
    $erreurs[] = "Les mots de passe ne correspondent pas";
}

if (empty($erreurs)) {
    try {
        // Vérifier si pseudo ou email déjà utilisé
        $stmt = $bdd->prepare("SELECT id_utilisateur FROM utilisateur WHERE pseudo = ? OR email = ?");
        $stmt->execute([$pseudo, $email]);

        if ($stmt->fetch()) {
            $erreurs[] = "Ce pseudo ou cet email est déjà utilisé";
        } else {
            $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

            $stmt2 = $bdd->prepare("INSERT INTO utilisateur (pseudo, email, mdp) VALUES (?, ?, ?)");
            $stmt2->execute([$pseudo, $email, $mdp_hash]);

            $_SESSION['succes'] = "Compte créé avec succès ! Vous pouvez vous connecter.";
            header('Location: ../public/connexion.php');
            exit;
        }
    } catch (PDOException $e) {
        $erreurs[] = "Erreur lors de l'inscription. Veuillez réessayer.";
    }
}

$_SESSION['erreurs'] = $erreurs;
$_SESSION['valeurs'] = $valeurs;
header('Location: ../public/inscription.php');
exit;