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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Commentaires</title>
    <link rel="stylesheet" href="../../ressources/css/dashboard.css">
</head>
<body>

<div class="layout">

    <aside class="sidebar">
        <div class="sidebar-stripe"></div>

        <div class="sidebar-logo">
            <div class="brand">⬡ Harmony</div>
            <div class="tagline">Panneau de contrôle</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Principal</div>
            <a class="nav-item" href="dashboard.php">
                <span class="ico">🏠</span> Tableau de bord
            </a>
            <a class="nav-item" href="utilisateur.php">
                <span class="ico">👥</span> Gérer les utilisateurs
            </a>

            <div class="nav-label">Contenu</div>
            <a class="nav-item" href="post.php">
                <span class="ico">📝</span> Gérer les posts
            </a>
            <a class="nav-item active" href="commentaires.php">
                <span class="ico">💬</span> Gérer les commentaires
            </a>

            <div class="nav-label">Administration</div>
            <a class="nav-item" href="ajouter_admin.php">
                <span class="ico">🛡️</span> Ajouter un admin
            </a>
            <a class="nav-item" href="activite.php">
                <span class="ico">📋</span> Journal d'activité
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="admin-card">
                <div class="av">AD</div>
                <div class="admin-info">
                    <div class="name">Administrateur</div>
                    <div class="role">Espace admin</div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">

        <header class="topbar">
            <div class="topbar-title">Gestion des commentaires</div>

            <div class="topbar-actions">
                <a class="btn btn-ghost btn-sm" href="dashboard.php">← Dashboard</a>
                <a class="btn btn-ghost btn-sm" href="../../index.php">Retour au site</a>

                <form action="../../traitement/deconnexion.php" method="post" style="display:inline;">
                    <button type="submit" class="btn btn-danger btn-sm">⏻ Déconnexion</button>
                </form>
            </div>
        </header>

        <div class="content">

            <div class="sec-hdr">
                <div class="sec-title">Liste des commentaires</div>
            </div>

            <?php if (!empty($succes)): ?>
                <div class="tcard" style="padding: 16px; margin-bottom: 16px; border-left: 4px solid var(--success);">
                    <?php foreach ($succes as $message): ?>
                        <p style="color: var(--success); margin-bottom: 6px;"><?= e($message) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($erreurs)): ?>
                <div class="tcard" style="padding: 16px; margin-bottom: 16px; border-left: 4px solid var(--danger);">
                    <?php foreach ($erreurs as $message): ?>
                        <p style="color: var(--danger); margin-bottom: 6px;"><?= e($message) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="tcard">
                <div class="ttoolbar">
                    <div class="toolbar-right">
                        <a class="btn btn-ghost btn-sm" href="dashboard.php">← Retour au tableau de bord</a>
                    </div>
                </div>

                <table>
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
                            <?php
                            $pseudo = $commentaire['pseudo'];
                            $initiales = strtoupper(substr($pseudo, 0, 2));

                            $couleurs = ['uav-green', 'uav-orange', 'uav-dark', 'uav-yellow'];
                            $avatarClass = $couleurs[((int)$commentaire['id_commentaire']) % count($couleurs)];
                            ?>
                            <tr>
                                <td>
                                    <span class="id-badge">
                                        #C<?= e((string)$commentaire['id_commentaire']) ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="comment-text">
                                        <?= e($commentaire['contenu']) ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="ucell">
                                        <div class="uav uav-sm <?= $avatarClass ?>">
                                            <?= e($initiales) ?>
                                        </div>
                                        <div>
                                            <div class="uname" style="font-size:.82rem;">
                                                <?= e($pseudo) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="comment-post-ref">
                                        <?= e($commentaire['titre']) ?>
                                    </span>
                                </td>

                                <td class="td-muted td-nowrap">
                                    <?= e($commentaire['date_commentaire']) ?>
                                </td>

                                <td>
                                    <div class="actbtns">
                                        <form action="../../traitement/admin/supprimer_commentaire.php"
                                              method="post"
                                              style="display:inline;"
                                              onsubmit="return confirm('Voulez-vous vraiment supprimer ce commentaire ?');">
                                            <input type="hidden"
                                                   name="id_commentaire"
                                                   value="<?= e((string)$commentaire['id_commentaire']) ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                🗑️ Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="td-muted">Aucun commentaire trouvé.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
</html>