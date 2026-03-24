<?php
session_start();
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../source/bdd/connexion_bdd.php');

$pdo = require_once(__DIR__ . '/../source/bdd/connexion_bdd.php');

$tri = isset($_GET['tri']) && $_GET['tri'] === 'asc' ? 'ASC' : 'DESC';
$sql = "SELECT * FROM poste ORDER BY date_poste $tri";
$stmt = $pdo->query($sql);
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Forum</title>
    <link rel="stylesheet" href="../ressources/css/forum.css">
</head>

<body>

<?php // include '../source/inclue/header.php'; ?>

<h2>Forum - Posts</h2>

<div class="btn-wrapper-right">
    <select class="btn-tri" onchange="trierPosts(this.value)">
        <option value="desc" <?php echo $tri === 'DESC' ? 'selected' : ''; ?>>Plus récent → Plus ancien</option>
        <option value="asc" <?php echo $tri === 'ASC' ? 'selected' : ''; ?>>Plus ancien → Plus récent</option>
    </select>
    <a href="post.php" class="btn-creer">+ Créer un post</a>
</div>

<hr>

<div class="posts">

    <?php if(empty($posts)){ ?>
        <p>Aucun post pour le moment.</p>
    <?php } else { ?>
        <?php foreach($posts as $post){ ?>
            <div class="post-card">
                <h3><a href="detail_post.php?id=<?php echo $post['id_poste']; ?>"><?php echo htmlspecialchars($post['titre']); ?></a></h3>
                <p><?php echo nl2br(htmlspecialchars($post['contenu'])); ?></p>
                <form action="../traitement/supprimer_post.php" method="POST">
                    <input type="hidden" name="id_poste" value="<?php echo $post['id_poste']; ?>">
                    <button type="submit" class="btn-supprimer">Supprimer</button>
                </form>
            </div>
        <?php } ?>
    <?php } ?>

</div>

<script>
    function trierPosts(ordre) {
        window.location.href = 'forum.php?tri=' + ordre;
    }
</script>

</body>
</html>