<?php
session_start();
require_once(__DIR__ . '/../source/bdd/connexion_bdd_jordan.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../public/connexion.php');
    exit();
}

if (isset($_POST['type']) && isset($_POST['id_poste'])) {
    $type           = $_POST['type'];
    $id_poste       = (int)$_POST['id_poste'];
    $id_utilisateur = (int)$_SESSION['id_utilisateur'];
    $id_commentaire = isset($_POST['id_commentaire']) && $_POST['id_commentaire'] !== '' ? (int)$_POST['id_commentaire'] : null;

    if ($id_commentaire) {
        $stmt = $bdd->prepare("SELECT id_reaction FROM reaction WHERE id_utilisateur = ? AND id_commentaire = ? AND type = ?");
        $stmt->execute([$id_utilisateur, $id_commentaire, $type]);
    } else {
        $stmt = $bdd->prepare("SELECT id_reaction FROM reaction WHERE id_utilisateur = ? AND id_poste = ? AND id_commentaire IS NULL AND type = ?");
        $stmt->execute([$id_utilisateur, $id_poste, $type]);
    }

    $existante = $stmt->fetch();

    if ($existante) {
        $stmt2 = $bdd->prepare("DELETE FROM reaction WHERE id_reaction = ?");
        $stmt2->execute([$existante['id_reaction']]);
    } else {
        $stmt2 = $bdd->prepare("INSERT INTO reaction (type, id_utilisateur, id_poste, id_commentaire) VALUES (?, ?, ?, ?)");
        $stmt2->execute([$type, $id_utilisateur, $id_poste, $id_commentaire]);
    }
}

header("Location: ../public/detail_post.php?id=" . $id_poste);
exit();