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
        commentaire.id_commentaire,
        commentaire.contenu,
        commentaire.date_commentaire,
        utilisateur.pseudo,
        poste.titre
    FROM commentaire
    INNER JOIN utilisateur 
        ON commentaire.id_utilisateur = utilisateur.id_utilisateur
    INNER JOIN poste 
        ON commentaire.id_poste = poste.id_poste
    ORDER BY commentaire.date_commentaire DESC
");

$commentaires = $requete->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Admin - Commentaires</title>
</head>
<body>

<header>
    <h1>Gestion des commentaires</h1>
    <p>Consultez et modérez les commentaires du forum.</p>
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
        <?php unset($succes); ?>
    <?php endif; ?>

    <?php if (!empty($erreurs)): ?>
        <div>
            <?php foreach ($erreurs as $message): ?>
                <p style="color: red;"><?= e($message) ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($erreurs); ?>
    <?php endif; ?>

    <section>
        <h2>Liste des commentaires</h2>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Commentaire</th>
                <th>Auteur</th>
                <th>Post associé</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            <?php if (!empty($commentaires)): ?>
                <?php foreach ($commentaires as $commentaire): ?>
                    <tr>
                        <td><?= e($commentaire['id_commentaire']) ?></td>
                        <td><?= e($commentaire['contenu']) ?></td>
                        <td><?= e($commentaire['pseudo']) ?></td>
                        <td><?= e($commentaire['titre']) ?></td>
                        <td><?= e($commentaire['date_commentaire']) ?></td>
                        <td>
                            <form action="../../traitement/admin/supprimer_commentaire.php" method="post" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer ce commentaire ?');">
                                <input type="hidden" name="id_commentaire" value="<?= e($commentaire['id_commentaire']) ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Aucun commentaire trouvé.</td>
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
