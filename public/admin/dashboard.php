<?php
session_start();

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../../source/fonctions/authentification.php');
require_once(__DIR__ . '/../../source/fonctions/admin.php');

exigerConnexion();
exigerAdmin();

$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');

$requete = $pdo->query("SELECT COUNT(*) FROM utilisateur");
$nbUtilisateurs = $requete->fetchColumn();

$requete = $pdo->query("SELECT COUNT(*) FROM utilisateur WHERE role = 'admin'");
$nbAdmins = $requete->fetchColumn();

$requete = $pdo->query("SELECT COUNT(*) FROM poste");
$nbPosts = $requete->fetchColumn();

$requete = $pdo->query("SELECT COUNT(*) FROM commentaire");
$nbCommentaires = $requete->fetchColumn();

$requete = $pdo->query("SELECT pseudo, date_inscription FROM utilisateur ORDER BY date_inscription DESC LIMIT 5");
$lastUsers = $requete->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tableau de bord</title>
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
            <a class="nav-item active" href="dashboard.php">
                <span class="ico">🏠</span> Tableau de bord
            </a>
            <a class="nav-item" href="utilisateurs.php">
                <span class="ico">👥</span> Gérer les utilisateurs
            </a>

            <div class="nav-label">Contenu</div>
            <a class="nav-item" href="post.php">
                <span class="ico">📝</span> Gérer les posts
            </a>
            <a class="nav-item" href="commentaires.php">
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
            <div class="topbar-title">Tableau de bord</div>

            <div class="topbar-actions">
                <a class="btn btn-ghost btn-sm" href="../../index.php">← Retour au site</a>

                <form action="../../traitement/deconnexion.php" method="post" style="display:inline;">
                    <button type="submit" class="btn btn-danger btn-sm">⏻ Déconnexion</button>
                </form>
            </div>
        </header>

        <div class="content">

            <div class="sec-hdr">
                <div class="sec-title">Vue d’ensemble</div>
            </div>

            <div class="stats-grid">
                <div class="stat-card c-blue">
                    <div class="stat-ico">👥</div>
                    <div class="stat-val"><?= htmlspecialchars((string) $nbUtilisateurs) ?></div>
                    <div class="stat-lbl">Utilisateurs</div>
                </div>

                <div class="stat-card c-orange">
                    <div class="stat-ico">🛡️</div>
                    <div class="stat-val"><?= htmlspecialchars((string) $nbAdmins) ?></div>
                    <div class="stat-lbl">Administrateurs</div>
                </div>

                <div class="stat-card c-green">
                    <div class="stat-ico">📝</div>
                    <div class="stat-val"><?= htmlspecialchars((string) $nbPosts) ?></div>
                    <div class="stat-lbl">Posts</div>
                </div>

                <div class="stat-card c-red">
                    <div class="stat-ico">💬</div>
                    <div class="stat-val"><?= htmlspecialchars((string) $nbCommentaires) ?></div>
                    <div class="stat-lbl">Commentaires</div>
                </div>
            </div>

            <div class="sec-hdr">
                <div class="sec-title">Derniers utilisateurs inscrits</div>
                <a class="btn btn-ghost btn-sm" href="utilisateurs.php">Voir tous →</a>
            </div>

            <div class="tcard">
                <table>
                    <thead>
                    <tr>
                        <th>Pseudo</th>
                        <th>Date d'inscription</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($lastUsers)): ?>
                        <?php foreach ($lastUsers as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['pseudo']) ?></td>
                                <td class="td-muted"><?= htmlspecialchars($user['date_inscription']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="td-muted">Aucun utilisateur trouvé.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="sec-hdr">
                <div class="sec-title">Gestion du site</div>
            </div>

            <div class="stats-grid">
                <a href="utilisateurs.php" class="stat-card" style="text-decoration:none; color:inherit;">
                    <div class="stat-ico">👥</div>
                    <div class="post-title-main">Gérer les utilisateurs</div>
                    <div class="td-muted">Consulter, modérer ou supprimer des comptes utilisateurs.</div>
                </a>

                <a href="post.php" class="stat-card" style="text-decoration:none; color:inherit;">
                    <div class="stat-ico">📝</div>
                    <div class="post-title-main">Gérer les posts</div>
                    <div class="td-muted">Voir les publications et intervenir si nécessaire.</div>
                </a>

                <a href="commentaires.php" class="stat-card" style="text-decoration:none; color:inherit;">
                    <div class="stat-ico">💬</div>
                    <div class="post-title-main">Gérer les commentaires</div>
                    <div class="td-muted">Modérer les commentaires et supprimer les contenus inappropriés.</div>
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>