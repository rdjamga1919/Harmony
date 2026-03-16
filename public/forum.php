<?php
require_once(__DIR__ . '/../source/bdd/connexion_bdd.php');

$sql = "SELECT * FROM poste ORDER BY id_poste DESC";
$stmt = $bdd->query($sql);
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Forum</title>
    <link rel="stylesheet" href="forum.css">
</head>

<body>

<?php // include '../source/inclue/header.php'; ?>

<h2>Forum - Posts</h2>

<div style="display: flex; justify-content: flex-end; padding: 10px 20px;">
    <a href="post.php" class="btn-creer">+ Créer un post</a>
</div>

<hr>

<div class="posts">

    <?php if(empty($posts)){ ?>
        <p>Aucun post pour le moment.</p>
    <?php } else { ?>
        <?php foreach($posts as $post){ ?>
            <div class="post">
                <h3><?php echo htmlspecialchars($post['titre']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($post['contenu'])); ?></p>
            </div>
        <?php } ?>
    <?php } ?>

</div>

</body>
</html>