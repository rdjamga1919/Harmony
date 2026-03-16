<?php
session_start();
require_once(__DIR__ . '/../../config.php');
require_once ROOT . '/source/fonctions/authentification.php';
require_once ROOT . '/source/fonctions/admin.php';
exigerConnexion();
exigerAdmin();
// ici, je mets la bdd juste pour extraire des infos pas de requêtes de traitements réelles
$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erreurs'] = ["Méthode non autorisée."];
    header('Location: ' . BASE_URL . '/public/admin/utilisateurs.php');
    exit;
}
if (empty($_POST['id_utilisateur'])){
    $_SESSION['erreurs'] = ["Utilisateur introuvable."];
    header('Location: ' . BASE_URL . '/public/admin/utilisateurs.php');
    exit();
}

$idUtilisateur = (int) $_POST['id_utilisateur']; //expliquer cette ligne

if ($idUtilisateur <= 0){
    $_SESSION['erreurs'] = ["Identifiant utilisateur invalide."];
    header('Location: ' . BASE_URL . '/public/admin/utilisateurs.php');
    exit();
}
try {
    $succes = promouvoirEnAdmin($pdo, $idUtilisateur);

    if ($succes) {
        $_SESSION['succes'] = ["L'utilisateur a été promu administrateur avec succès."];
    } else {
        $_SESSION['erreurs'] = ["Impossible de promouvoir cet utilisateur en administrateur."];
    }
} catch (PDOException $e) {
    error_log("Erreur promotion admin : " . $e->getMessage());
    $_SESSION['erreurs'] = ["Une erreur est survenue lors de la promotion de l'utilisateur."];
}

header('Location:' . BASE_URL .'/public/admin/utilisateurs.php');
exit;