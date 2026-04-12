<?php
session_start();

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../../source/fonctions/authentification.php');
require_once __DIR__ . '/../../source/fonctions/admin.php';

exigerConnexion();
exigerAdmin();

$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');

$requete = $pdo->query("
    SELECT id_utilisateur, pseudo, email, role, date_inscription
    FROM utilisateur
    ORDER BY id_utilisateur DESC
");
$utilisateurInfo = $requete->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Utilisateurs</title>
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
            <a class="nav-item active" href="utilisateur.php">
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
            <div class="topbar-title">Gestion des utilisateurs</div>

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
                <div class="sec-title">Liste des utilisateurs</div>
            </div>

            <?php if (!empty($_SESSION['succes'])): ?>
                <div class="tcard" style="padding: 16px; margin-bottom: 16px; border-left: 4px solid var(--success);">
                    <?php foreach ($_SESSION['succes'] as $message): ?>
                        <p style="color: var(--success); margin-bottom: 6px;">
                            <?= htmlspecialchars($message) ?>
                        </p>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['succes']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['erreurs'])): ?>
                <div class="tcard" style="padding: 16px; margin-bottom: 16px; border-left: 4px solid var(--danger);">
                    <?php foreach ($_SESSION['erreurs'] as $message): ?>
                        <p style="color: var(--danger); margin-bottom: 6px;">
                            <?= htmlspecialchars($message) ?>
                        </p>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['erreurs']); ?>
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
                        <th>Utilisateur</th>
                        <th>Rôle</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if (!empty($utilisateurInfo)): ?>
                        <?php foreach ($utilisateurInfo as $utilisateur): ?>
                            <?php
                            $pseudo = $utilisateur['pseudo'];
                            $email = $utilisateur['email'];
                            $role = $utilisateur['role'];
                            $idUtilisateur = (int) $utilisateur['id_utilisateur'];

                            $initiales = strtoupper(substr($pseudo, 0, 2));

                            $avatarClass = 'uav-green';
                            if ($role === 'admin') {
                                $avatarClass = 'uav-orange';
                            }
                            ?>
                            <tr>
                                <td>
                                    <span class="id-badge">
                                        #U<?= htmlspecialchars((string) $idUtilisateur) ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="ucell">
                                        <div class="uav <?= $avatarClass ?>">
                                            <?= htmlspecialchars($initiales) ?>
                                        </div>
                                        <div>
                                            <div class="uname"><?= htmlspecialchars($pseudo) ?></div>
                                            <div class="uemail"><?= htmlspecialchars($email) ?></div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <?php if ($role === 'admin'): ?>
                                        <span class="badge b-admin">Admin</span>
                                    <?php else: ?>
                                        <span class="badge b-user">Utilisateur</span>
                                    <?php endif; ?>
                                </td>

                                <td class="td-muted">
                                    <?= htmlspecialchars($utilisateur['date_inscription']) ?>
                                </td>

                                <td>
                                    <div class="actbtns" style="flex-wrap: wrap; gap: 8px;">

                                        <?php if ($role === 'admin'): ?>
                                            <span class="badge b-admin">Déjà admin</span>
                                        <?php else: ?>
                                            <form action="../../traitement/admin/creer_admin.php"
                                                  method="post"
                                                  style="display:inline;"
                                                  onsubmit="return confirm('Promouvoir cet utilisateur en administrateur ?');">
                                                <input type="hidden"
                                                       name="id_utilisateur"
                                                       value="<?= htmlspecialchars((string) $idUtilisateur) ?>">
                                                <button type="submit" class="btn btn-ghost btn-sm">
                                                    🛡️ Promouvoir
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if ($idUtilisateur !== (int) $_SESSION['id_utilisateur']): ?>
                                            <form action="../../traitement/admin/supprimer_user.php"
                                                  method="post"
                                                  style="display:inline;"
                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                                <input type="hidden"
                                                       name="id_utilisateur"
                                                       value="<?= htmlspecialchars((string) $idUtilisateur) ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    🗑️ Supprimer
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="badge b-active">Votre compte</span>
                                        <?php endif; ?>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="td-muted">Aucun utilisateur trouvé.</td>
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
