<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../source/fonctions/authentification.php');
$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titre = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');

    if (empty($titre) || empty($contenu)) {
        header("Location: ../pages/creer_post.php?error=champs_obligatoires");
        exit;
    }
    $id_utilisateur = $_SESSION['id_utilisateur'] ?? 1;
    $id_categorie = $_POST['id_categorie'] ?? 1;
    $est_anonyme = isset($_POST['est_anonyme']) ? 1 : 0;

    $sql = "INSERT INTO poste (titre, contenu, id_utilisateur, id_categorie, est_anonyme) 
    VALUES (:titre, :contenu, :id_utilisateur, :id_categorie, :est_anonyme)";

    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        ':titre' => $titre,
        ':contenu' => $contenu,
        ':id_utilisateur' => $id_utilisateur,
        ':id_categorie' => $id_categorie,
        ':est_anonyme' => $est_anonyme
    ]);

    header("Location: ../public/forum.php?success=1");
    exit;
}
