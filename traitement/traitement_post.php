<?php
session_start();
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../source/fonctions/authentification.php');
$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');

if(isset($_POST['titre']) && isset($_POST['contenu'])){

    $titre   = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);

    // à remplacer par $_SESSION['id_utilisateur'] si tu as une session
    $id_utilisateur = 1;
    $id_categorie   = 1;

    $sql = "INSERT INTO poste (titre, contenu, id_utilisateur, id_categorie) VALUES (:titre, :contenu, :id_utilisateur, :id_categorie)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'titre'          => $titre,
        'contenu'        => $contenu,
        'id_utilisateur' => $id_utilisateur,
        'id_categorie'   => $id_categorie
    ]);

    // redirection vers le forum
    header("Location: ../public/forum.php");
    exit();
}
?>