<?php
session_start();
require_once(__DIR__ . '/../source/bdd/connexion_bdd_jordan.php');

if (!isset($_GET['id'])) {
    header('Location: forum.php');
    exit();
}

$id = (int)$_GET['id'];
$id_utilisateur = $_SESSION['id_utilisateur'] ?? null;

// Récupérer le post
$stmt = $bdd->prepare("SELECT * FROM poste WHERE id_poste = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    header('Location: forum.php');
    exit();
}

// Récupérer les réactions du post
$stmt_r = $bdd->prepare("SELECT type, COUNT(*) as total FROM reaction WHERE id_poste = ? AND id_commentaire IS NULL GROUP BY type");
$stmt_r->execute([$id]);
$reactions_post = [];
foreach ($stmt_r->fetchAll() as $r) {
    $reactions_post[$r['type']] = $r['total'];
}

// Récupérer les commentaires
$stmt2 = $bdd->prepare("SELECT * FROM commentaire WHERE id_poste = ? ORDER BY date_commentaire ASC");
$stmt2->execute([$id]);
$commentaires = $stmt2->fetchAll();

// Récupérer les réactions par commentaire
$reactions_com = [];
foreach ($commentaires as $com) {
    $stmt_rc = $bdd->prepare("SELECT type, COUNT(*) as total FROM reaction WHERE id_commentaire = ? GROUP BY type");
    $stmt_rc->execute([$com['id_commentaire']]);
    foreach ($stmt_rc->fetchAll() as $r) {
        $reactions_com[$com['id_commentaire']][$r['type']] = $r['total'];
    }
}

$url_post = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($post['titre']); ?></title>
    <link rel="stylesheet" href="../ressources/css/forum.css">
</head>
<body>

<h2><?php echo htmlspecialchars($post['titre']); ?></h2>

<div class="post-card">
    <p><?php echo nl2br(htmlspecialchars($post['contenu'])); ?></p>

    <!-- Réactions post -->
    <div class="reactions">
        <?php foreach (['soutien' => '🤝', 'merci' => '🙏', 'courage' => '💪'] as $type => $emoji){ ?>
            <form action="../traitement/traitement_reaction.php" method="POST" class="form-reaction">
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <input type="hidden" name="id_poste" value="<?php echo $id; ?>">
                <input type="hidden" name="id_utilisateur" value="<?php echo $id_utilisateur; ?>">
                <button type="submit" class="btn-reaction">
                    <?php echo $emoji; ?> <?php echo $type; ?>
                    <span class="reaction-count"><?php echo $reactions_post[$type] ?? 0; ?></span>
                </button>
            </form>
        <?php } ?>

        <!-- Partage -->
        <button class="btn-reaction" onclick="copierLien()">🔗 Copier le lien</button>
        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($url_post); ?>&text=<?php echo urlencode($post['titre']); ?>" target="_blank" class="btn-reaction">🐦 Twitter</a>
    </div>
</div>

<h3>Commentaires (<?php echo count($commentaires); ?>)</h3>

<div class="posts">
    <?php if (empty($commentaires)){ ?>
        <p>Aucun commentaire pour le moment.</p>
    <?php } else { ?>
        <?php foreach ($commentaires as $com){ ?>
            <div class="post-card">
                <p><?php echo nl2br(htmlspecialchars($com['contenu'])); ?></p>
                <div class="post-meta"><?php echo $com['date_commentaire']; ?></div>

                <!-- Réactions commentaire -->
                <div class="reactions">
                    <?php foreach (['soutien' => '🤝', 'merci' => '🙏', 'courage' => '💪'] as $type => $emoji){ ?>
                        <form action="../traitement/traitement_reaction.php" method="POST" class="form-reaction">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <input type="hidden" name="id_poste" value="<?php echo $id; ?>">
                            <input type="hidden" name="id_commentaire" value="<?php echo $com['id_commentaire']; ?>">
                            <input type="hidden" name="id_utilisateur" value="<?php echo $id_utilisateur; ?>">
                            <button type="submit" class="btn-reaction">
                                <?php echo $emoji; ?>
                                <span class="reaction-count"><?php echo $reactions_com[$com['id_commentaire']][$type] ?? 0; ?></span>
                            </button>
                        </form>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<div class="btn-wrapper-right">
    <a href="commenter.php?id=<?php echo $post['id_poste']; ?>" class="btn-creer">+ Ajouter un commentaire</a>
</div>

<div class="btn-wrapper-center">
    <a href="forum.php" class="btn-retour">Retour au forum</a>
</div>

<script>
    function copierLien() {
        navigator.clipboard.writeText('<?php echo $url_post; ?>');
        alert('Lien copié !');
    }
</script>

</body>
</html>