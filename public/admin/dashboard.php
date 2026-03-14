<?php
require_once(__DIR__ . '/../../source/fonctions/authentification.php');

if (!estAdmin()) {
    exigerConnexion();
}
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
    <p>Bienvenue dans l’espace d’administration de Harmony.</p>
</header>

<main>
    <section>
        <h2>Vue d’ensemble</h2>

        <div class="stats-container">
            <article class="stat-card">
                <h3>Utilisateurs</h3>
                <p class="stat-number">25</p>
                <!-- Remplace 25 par ton PHP plus tard -->
            </article>

            <article class="stat-card">
                <h3>Posts</h3>
                <p class="stat-number">48</p>
                <!-- Remplace 48 par ton PHP plus tard -->
            </article>

            <article class="stat-card">
                <h3>Commentaires</h3>
                <p class="stat-number">132</p>
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

            <a href="posts.php" class="admin-card">
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
    <form action="/../traitement/deconnexion.php" method="post">
        <button type="submit">Se déconnecter</button>
    </form>
</main>

<footer>
</footer>

</body>
</html>