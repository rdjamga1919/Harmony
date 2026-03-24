<?php
session_start();
require_once(__DIR__ . '/../source/bdd/connexion_bdd_jordan.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../public/connexion.php');
    exit();
}

if (isset($_POST['contenu']) && isset($_POST['id_poste'])) {
    $contenu        = trim($_POST['contenu']);
    $id_poste       = (int)$_POST['id_poste'];
    $id_utilisateur = (int)$_SESSION['id_utilisateur'];

    if (!empty($contenu)) {
        $stmt = $bdd->prepare("INSERT INTO commentaire (contenu, id_utilisateur, id_poste) VALUES (?, ?, ?)");
        $stmt->execute([$contenu, $id_utilisateur, $id_poste]);
    }
}

header("Location: ../public/detail_post.php?id=" . $id_poste);
exit();