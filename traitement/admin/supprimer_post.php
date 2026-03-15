<?php
session_start();

require_once(__DIR__ . '/../../config.php');
require_once ROOT . '/source/fonctions/authentification.php';
require_once ROOT . '/source/fonctions/admin.php';

exigerConnexion();
exigerAdmin();

$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erreurs'] = ["Méthode non autorisée."];
    header('Location: ' . BASE_URL . '/public/admin/post.php');
    exit;
}

if (empty($_POST['id_poste'])){
    $_SESSION['erreurs'] = ["Poste introuvable."];
    header('Location: ' . BASE_URL . '/public/admin/post.php');
    exit();
}


$idPoste = (int) $_POST['id_poste'];
if ($idPoste <= 0){
    $_SESSION['erreurs'] = ["Identifiant du post invalide."];
    header('Location: ' . BASE_URL . '/public/admin/post.php');
    exit();
}


try {
    $succes = supprimerPost($pdo, $idPoste);

    if ($succes) {
        $_SESSION['succes'] = ["Le post a été supprimé avec succès."];
    } else {
        $_SESSION['erreurs'] = ["Impossible de supprimer ce post."];
    }
} catch (PDOException $e) {
    error_log("Erreur suppression post : " . $e->getMessage());
    $_SESSION['erreurs'] = ["Une erreur est survenue lors de la suppression du post."];
}

header('Location: ' . BASE_URL . '/public/admin/post.php');
exit;
