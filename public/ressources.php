<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../source/fonctions/authentification.php');
$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');

$id_categorie = filter_input(INPUT_GET, 'cat', FILTER_VALIDATE_INT);


$sql = "SELECT r.*, c.nom as nom_categorie 
        FROM ressources r 
        JOIN categorie c ON r.id_categorie = c.id_categorie";
$params = [];

if ($id_categorie) {
    $sql .= " WHERE r.id_categorie = :id_categorie";
    $params[':id_categorie'] = $id_categorie;
}

$sql .= " ORDER BY r.id_categorie, r.titre ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$ressources = $stmt->fetchAll();


$stmtCat = $pdo->query("SELECT id_categorie, nom FROM categorie ORDER BY nom");
$categories = $stmtCat->fetchAll();
?>

<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ressources & Aide</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>/public/forum.css">
    <style>
        /* Styles spécifiques généré par ia à modifier */
        .filtres-wrapper { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 2rem; }
        .btn-filtre {
            padding: 10px 20px; border: 1px solid #ccc; border-radius: 20px;
            text-decoration: none; color: #333; background: #f9f9f9; transition: 0.3s;
        }
        .btn-filtre:hover, .btn-filtre.actif { background: #007bff; color: white; border-color: #007bff; }

        .ressources-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .carte-ressource {
            border: 1px solid #ddd; border-radius: 8px; padding: 20px;
            background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .tag {
            display: inline-block; padding: 4px 8px; border-radius: 4px;
            font-size: 0.8rem; font-weight: bold; margin-bottom: 10px;
            background: #eef2f7; color: #555;
        }
        .btn-lien {
            display: inline-block; margin-top: 15px; padding: 8px 15px;
            background: #28a745; color: white; text-decoration: none; border-radius: 5px;
        }
        .btn-lien:hover { background: #218838; }
    </style>
</head>
<body>

<?php include ROOT . '/source/inclue/header.php'; ?>

<div class="container" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
    <h1>Ressources & Aide</h1>
    <p>Des articles, numéros et contacts utiles pour vous accompagner.</p>

    <!-- Filtres Catégories -->
    <div class="filtres-wrapper">
        <a href="ressources.php" class="btn-filtre <?= !$id_categorie ? 'actif' : '' ?>">Tous</a>
        <?php foreach($categories as $cat): ?>
            <a href="ressources.php?cat=<?= $cat['id_categorie'] ?>" class="btn-filtre <?= $id_categorie == $cat['id_categorie'] ? 'actif' : '' ?>">
                <?= htmlspecialchars($cat['nom']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Liste des Ressources -->
    <div class="ressources-grid">
        <?php if (count($ressources) > 0): ?>
            <?php foreach($ressources as $r): ?>
                <div class="carte-ressource">
                    <span class="tag"><?= htmlspecialchars($r['nom_categorie']) ?></span>
                    <h3><?= htmlspecialchars($r['titre']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($r['description'])) ?></p>

                    <?php if($r['type'] == 'numero'): ?>
                        <div style="font-size: 1.2rem; font-weight: bold; color: #d9534f; margin-top: 10px;">
                            <?= htmlspecialchars($r['lien']) ?>
                        </div>
                    <?php else: ?>
                        <a href="<?= htmlspecialchars($r['lien']) ?>" target="_blank" class="btn-lien" rel="noopener noreferrer">
                            Accéder à la ressource →
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune ressource trouvée dans cette catégorie.</p>
        <?php endif; ?>
    </div>

    <div class="btn-wrapper-center" style="margin-top: 40px;">
        <a href="forum.php" class="btn-retour">Retour au forum</a>
    </div>
</div>

</body>
</html>