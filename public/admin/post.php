<?php
session_start();

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../source/fonctions/authentification.php';
require_once __DIR__ . '/../../source/fonctions/admin.php';

exigerConnexion();
exigerAdmin();

$pdo = require_once ROOT . '/source/bdd/connexion_bdd.php';

$requete = $pdo->query("
    SELECT 
        poste.id_poste,
        poste.titre,
        poste.date_poste,
        utilisateur.pseudo,
        COUNT(commentaire.id_commentaire) AS nb_commentaires
    FROM poste
    INNER JOIN utilisateur
        ON poste.id_utilisateur = utilisateur.id_utilisateur
    LEFT JOIN commentaire
        ON commentaire.id_poste = poste.id_poste
    GROUP BY poste.id_poste, poste.titre, poste.date_poste, utilisateur.pseudo
    ORDER BY poste.date_poste DESC
");

$posts = $requete->fetchAll(PDO::FETCH_ASSOC);

$erreurs = $_SESSION['erreurs'] ?? [];
$succes = $_SESSION['succes'] ?? [];

if (!is_array($erreurs)) {
    $erreurs = [$erreurs];
}

if (!is_array($succes)) {
    $succes = [$succes];
}

unset($_SESSION['erreurs'], $_SESSION['succes']);

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Posts</title>
</head>
<body>

<header>
    <h1>Gestion des posts</h1>
    <p>Consultez et modérez les publications du forum.</p>
</header>

<main>

    <section>
        <h2>Actions rapides</h2>
        <p><a href="dashboard.php">← Retour au tableau de bord</a></p>
    </section>

    <?php if (!empty($succes)): ?>
        <div>
            <?php foreach ($succes as $message): ?>
                <p style="color: green;"><?= e($message) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($erreurs)): ?>
        <div>
            <?php foreach ($erreurs as $message): ?>
                <p style="color: red;"><?= e($message) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <section>
        <h2>Liste des posts</h2>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Date</th>
                <th>Commentaires</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>

            <?php if (!empty($posts)): ?>

                <?php foreach ($posts as $post): ?>

                    <tr>

                        <td><?= e($post['id_poste']) ?></td>

                        <td><?= e($post['titre']) ?></td>

                        <td><?= e($post['pseudo']) ?></td>

                        <td><?= e($post['date_poste']) ?></td>

                        <td><?= e($post['nb_commentaires']) ?></td>

                        <td>

                            <form action="../../traitement/admin/supprimer_post.php"
                                  method="post"
                                  style="display:inline;"
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ce post ?');">

                                <input type="hidden"
                                       name="id_poste"
                                       value="<?= e($post['id_poste']) ?>">

                                <button type="submit">Supprimer</button>

                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="6">Aucun post trouvé.</td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </section>

    <section>
        <h2>Navigation</h2>
        <p><a href="../../index.php">Retour au site</a></p>
    </section>

    <form action="../../traitement/deconnexion.php" method="post">
        <button type="submit">Se déconnecter</button>
    </form>

</main>

<footer>
</footer>

</body>
</html>