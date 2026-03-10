<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harmony - Accueil</title>
</head>
<body>

<header>
    <h1>Harmony</h1>
    <p>Une plateforme pensée par des étudiants, pour des étudiants.</p>

    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="public/ressources.php">Ressources</a></li>
            <li><a href="public/forum.php">Forum</a></li>
            <li><a href="public/connexion.php">Connexion</a></li>
            <li><a href="public/inscription.php">Inscription</a></li>
        </ul>
    </nav>
</header>

<main>

    <section>
        <h2>Bienvenue sur Harmony</h2>
        <p>
            Harmony est une plateforme dédiée aux étudiants autour des questions de santé mentale,
            de bien-être et d'entraide. Elle combine des ressources fiables avec un espace
            communautaire participatif où chacun peut échanger, témoigner et trouver du soutien.
        </p>
    </section>

    <section>
        <h2>Pourquoi Harmony ?</h2>
        <p>
            De nombreuses plateformes existent déjà, comme Santé Psy Étudiant, Nightline France
            ou Fil Santé Jeunes. Elles proposent des informations utiles ou des espaces d’écoute,
            mais restent souvent institutionnelles ou centrées sur des échanges ponctuels.
        </p>
        <p>
            Harmony se distingue par son approche hybride : informer, rassembler et permettre
            aux étudiants de s’exprimer dans un cadre bienveillant.
        </p>
    </section>

    <section>
        <h2>Notre valeur ajoutée</h2>
        <ul>
            <li>Une plateforme conçue par des étudiants et pour des étudiants</li>
            <li>Un espace d’échange communautaire inspiré des forums</li>
            <li>Des ressources informatives accessibles et centralisées</li>
            <li>Un lieu pour témoigner, partager et s’entraider</li>
            <li>Une volonté de lutter contre l’isolement et de créer du lien social</li>
        </ul>
    </section>

    <section>
        <h2>Ce que vous pouvez faire sur Harmony</h2>

        <article>
            <h3>Consulter des ressources</h3>
            <p>
                Retrouvez des informations claires et utiles sur la santé mentale,
                le bien-être étudiant et les aides existantes.
            </p>
            <p><a href="public/ressources.php">Voir les ressources</a></p>
        </article>

        <article>
            <h3>Échanger avec la communauté</h3>
            <p>
                Posez vos questions, partagez votre vécu et discutez avec d’autres étudiants
                dans un espace participatif et bienveillant.
            </p>
            <p><a href="public/forum.php">Accéder au forum</a></p>
        </article>

    </section>

    <section>
        <h2>Rejoindre Harmony</h2>
        <p>
            Créez un compte pour participer aux discussions, publier des témoignages
            et contribuer à une communauté d’entraide étudiante.
        </p>
        <p>
            <a href="public/inscription.php">S'inscrire</a> |
            <a href="public/connexion.php">Se connecter</a>
        </p>
    </section>

</main>

<footer>
    <p>&copy; 2026 Harmony - Tous droits réservés.</p>
</footer>

</body>
</html>
