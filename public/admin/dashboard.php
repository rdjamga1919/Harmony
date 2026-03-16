<?php
session_start();
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../../source/fonctions/authentification.php');
require_once __DIR__ . '/../../source/fonctions/admin.php';
exigerConnexion();
exigerAdmin();
// ici je met la bdd juste pour extraire des infos pas de requtes de traitements reeles
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
$lastUsers = $requete->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC important quand je recup plusieur données pour en faire un tableau associatif

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Accueil</title>
</head>
<body>

<header>
    <h1>Tableau de bord administrateur</h1>
    <p>Bienvenue dans l’espace d’administration d'Harmony.</p>
</header>

<main>
    <section>
        <h2>Vue d’ensemble</h2>

        <div class="stats-container">
            <article class="stat-card">
                <h3>Derniers utilisateurs inscrits</h3>
                <p class="stat-number"><?php if (!empty($lastUsers)): ?>
                <ul>
                    <?php foreach ($lastUsers as $user): ?>
                        <li>
                            <?= htmlspecialchars($user['pseudo']) ?>
                            -
                            <?= htmlspecialchars($user['date_inscription']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p>Aucun utilisateur trouvé.</p>
                <?php endif; ?></p>
                <!-- Remplace 25 par ton PHP plus tard -->
            </article>
            <article class="stat-card">
                <h3>Utilisateurs</h3>
                <p class="stat-number"><?= $nbUtilisateurs ?></p>
                <!-- Remplace 25 par ton PHP plus tard -->
            </article>
            <article class="stat-card">
                <h3>Administrateurs</h3>
                <p class="stat-number"><?= $nbAdmins ?></p>
            </article>
            <article class="stat-card">
                <h3>Posts</h3>
                <p class="stat-number"><?= $nbPosts ?></p>
                <!-- Remplace 48 par ton PHP plus tard -->
            </article>

            <article class="stat-card">
                <h3>Commentaires</h3>
                <p class="stat-number"><?= $nbCommentaires ?></p>
                <!-- Remplace 132 par ton PHP plus tard -->
            </article>
        </div>
    </section>

    <section>
        <h2>Gestion du site</h2>

        <div class="admin-links">
            <a href="utilisateurs.php" class="admin-card">
                <h3>Gérer les utilisateurs</h3>
                <p>Consulter, modérer ou supprimer des comptes utilisateurs.</p>
            </a>

            <a href="post.php" class="admin-card">
                <h3>Gérer les posts</h3>
                <p>Voir les publications et intervenir si nécessaire.</p>
            </a>

            <a href="commentaires.php" class="admin-card">
                <h3>Gérer les commentaires</h3>
                <p>Modérer les commentaires et supprimer les contenus inappropriés.</p>
            </a>
        </div>
    </section>

    <section>
        <h2>Navigation</h2>
        <p><a href="/index.php">Retour au site</a></p>
    </section>
    <form action="../../traitement/deconnexion.php" method="post">
        <button type="submit">Se déconnecter</button>
    </form>
</main>

<footer>
</footer>

</body>
</html>