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
    header('Location: ' . BASE_URL . '/public/admin/commentaires.php');
    exit;
}

if (empty($_POST['id_commentaire'])){
    $_SESSION['erreurs'] = ["Commentaire introuvable."];
    header('Location: ' . BASE_URL . '/public/admin/commentaires.php');
    exit();
}

/* If (empty($_POST['id_utilisateur'])){
    $_SESSION['erreurs'] = ["Utilisateur introuvable."];
    header('Location: ' . BASE_URL . '/public/admin/commentaires.php');
    exit();
}
if (empty($_POST['id_poste'])){
    $_SESSION['erreurs'] = ["Post introuvable."];
    header('Location: ' . BASE_URL . '/public/admin/commentaires.php');
    exit();
}*/

$idCommentaire = (int) $_POST['id_commentaire']; //expliquer cette ligne
if ($idCommentaire <= 0){
    $_SESSION['erreurs'] = ["Identifiant du commentaire invalide."];
    header('Location: ' . BASE_URL . '/public/admin/commentaires.php');
    exit();
}


try {

    $succes = supprimerCommentaire($pdo, $idCommentaire);

    if ($succes) {
        $_SESSION['succes'] = ["Le commentaires a été supprimer avec succès."];
    } else {
        $_SESSION['erreurs'] = ["Impossible de supprimer ce commentaires."];
    }
} catch (PDOException $e) {
    error_log("Erreur suppression commentaires : " . $e->getMessage());
    $_SESSION['erreurs'] = ["Une erreur est survenue lors de la suppression du commentaires."];
}

header('Location:' . BASE_URL .'/public/admin/commentaires.php');
exit;
