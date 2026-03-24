<?php

// cette pages jsuis vrmt pas serais j'ai demandé de tester des trucs de fou donc si tu vois que c'est trop de la d supprime 
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../source/fonctions/authentification.php');
$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');

// Récupère l'ID du post depuis l'URL
$id_poste = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id_poste) {
    header("Location: " . ROOT_URL . "/pages/forum.php");
    exit;
}

// 1. Récupérer le post + infos auteur + catégorie
$stmt = $pdo->prepare("
    SELECT p.*, u.pseudo, c.nom as nom_categorie 
    FROM poste p 
    JOIN utilisateur u ON p.id_utilisateur = u.id_utilisateur 
    JOIN categorie c ON p.id_categorie = c.id_categorie 
    WHERE p.id_poste = ?
");
$stmt->execute([$id_poste]);
$post = $stmt->fetch();

if (!$post) {
    header("Location: " . ROOT_URL . "/pages/forum.php?error=post_introuvable");
    exit;
}

// 2. Récupérer les commentaires
$stmt = $pdo->prepare("
    SELECT c.*, u.pseudo 
    FROM commentaire c 
    JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur 
    WHERE c.id_poste = ? 
    ORDER BY c.date_commentaire ASC
");
$stmt->execute([$id_poste]);
$commentaires = $stmt->fetchAll();

// 3. Récupérer les réactions (optionnel)
$stmt = $pdo->prepare("SELECT type, COUNT(*) as nb FROM reaction WHERE id_poste = ? GROUP BY type");
$stmt->execute([$id_poste]);
$reactions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['titre']) ?></title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>/public/forum.css">
</head>
<body>

<?php include ROOT . '/source/inclue/header.php'; ?>

<div class="container" style="max-width: 800px; margin: 40px auto; padding: 0 20px;">

    <!-- Message de succès après commentaire -->
    <?php if(isset($_GET['success'])): ?>
        <p class="success">✅ Commentaire ajouté !</p>
    <?php endif; ?>

    <!-- LE POST -->
    <article class="post-detail">
        <div class="post-header">
            <span class="badge"><?= htmlspecialchars($post['nom_categorie']) ?></span>
            <?php if($post['est_anonyme']): ?>
                <span class="auteur">Anonyme</span>
            <?php else: ?>
                <span class="auteur">Par <?= htmlspecialchars($post['pseudo']) ?></span>
            <?php endif; ?>
            <span class="date"><?= date('d/m/Y à H:i', strtotime($post['date_poste'])) ?></span>
        </div>

        <h1><?= htmlspecialchars($post['titre']) ?></h1>
        <div class="post-content"><?= nl2br(htmlspecialchars($post['contenu'])) ?></div>

        <!-- Réactions (optionnel) -->
        <div class="reactions">
            <span>🤝 Soutien : <?= $reactions['soutien'] ?? 0 ?></span>
            <span>💪 Courage : <?= $reactions['courage'] ?? 0 ?></span>
            <span>🙏 Merci : <?= $reactions['merci'] ?? 0 ?></span>
        </div>
    </article>

    <!-- FORMULAIRE COMMENTAIRE -->
    <?php if(est_connecte()): ?>
        <div class="form-commentaire">
            <h3>💬 Laisser un commentaire</h3>
            <form action="<?= ROOT_URL ?>/traitement/traitement_commentaire.php" method="POST">
                <input type="hidden" name="id_poste" value="<?= $id_poste ?>">
                <textarea name="contenu" rows="4" required placeholder="Votre réponse..."></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    <?php else: ?>
        <p class="info">🔒 <a href="<?= ROOT_URL ?>/pages/connexion.php">Connectez-vous</a> pour commenter.</p>
    <?php endif; ?>

    <!-- LISTE DES COMMENTAIRES -->
    <div class="commentaires-list">
        <h3><?= count($commentaires) ?> commentaire(s)</h3>

        <?php if(count($commentaires) > 0): ?>
            <?php foreach($commentaires as $com): ?>
                <div class="commentaire">
                    <div class="com-header">
                        <strong><?= htmlspecialchars($com['pseudo']) ?></strong>
                        <small><?= date('d/m/Y H:i', strtotime($com['date_commentaire'])) ?></small>
                    </div>
                    <div class="com-content"><?= nl2br(htmlspecialchars($com['contenu'])) ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Soyez le premier à commenter !</p>
        <?php endif; ?>
    </div>

    <div class="btn-wrapper-center" style="margin-top: 30px;">
        <a href="<?= ROOT_URL ?>/pages/forum.php" class="btn-retour">← Retour au forum</a>
    </div>

</div>

</body>
</html>
