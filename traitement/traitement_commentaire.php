<?php

require_once(__DIR__ . '/../../config.php');

try {
    $pdo = require_once(__DIR__ . '/../bdd/connexion_bdd.php');
} catch (Exception $e) {
    die("Erreur de connexion à la base de données.");
}

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: ../../public/connexion.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $contenu = trim($_POST['contenu'] ?? '');
    $id_poste = filter_input(INPUT_POST, 'id_poste', FILTER_VALIDATE_INT);

    // Vérifications de sécurité
    if (empty($contenu) || !$id_poste) {
        header("Location: ../../public/voir_post.php?id=$id_poste&error=1");
        exit;
    }

    $id_utilisateur = $_SESSION['id_utilisateur'];

    // Insertion du commentaire
    $stmt = $pdo->prepare("
        INSERT INTO commentaire (contenu, id_utilisateur, id_poste) 
        VALUES (:contenu, :id_utilisateur, :id_poste)
    ");

    $stmt->execute([
        ':contenu' => $contenu,
        ':id_utilisateur' => $id_utilisateur,
        ':id_poste' => $id_poste
    ]);

    // Redirection succès
    header("Location: ../../public/voir_post.php?id=$id_poste&success=1");
    exit;
}
?>