<?php

session_start();
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../../source/fonctions/authentification.php');
require_once __DIR__ . '/../../source/fonctions/admin.php';
exigerConnexion();
exigerAdmin();

// ici je met la bdd juste pour extraire des infos pas de requtes de traitements reeles
$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');
$requete = $pdo->query("SELECT id_utilisateur, pseudo, email, role, date_inscription FROM utilisateur");
$utilisateurInfo = $requete->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Utilisateurs</title>
</head>
<body>

<header>
    <h1>Gestion des utilisateurs</h1>
    <p>Consultez les comptes utilisateurs et effectuez les actions d’administration.</p>
</header>

<main>
    <section>
        <h2>Actions rapides</h2>
        <p><a href="dashboard.php">← Retour au tableau de bord</a></p>
    </section>

    <section>
        <h2>Liste des utilisateurs</h2>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Date d'inscription</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>1</td>
                <td>admin</td>
                <td>admin@adalo.com</td>
                <td>admin</td>
                <td>29/01/2026</td>
                <td>
                    <p>Compte administrateur principal</p>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>alex</td>
                <td>alex@test.com</td>
                <td>etudiant</td>
                <td>29/01/2026</td>
                <td>
                    <form action="/traitement/admin/creer_admin.php" method="post" style="display:inline;">
                        <input type="hidden" name="id_utilisateur" value="2">
                        <button type="submit">Promouvoir admin</button>
                    </form>

                    <form action="../../traitement/admin/supprimer_user.php" method="post" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                        <input type="hidden" name="id_utilisateur" value="2">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td>sarah</td>
                <td>sarah@test.com</td>
                <td>etudiant</td>
                <td>29/01/2026</td>
                <td>
                    <form action="../../traitement/admin/creer_admin.php" method="post" style="display:inline;">
                        <input type="hidden" name="id_utilisateur" value="3">
                        <button type="submit">Promouvoir admin</button>
                    </form>

                    <form action="../../traitement/admin/supprimer_user.php" method="post" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                        <input type="hidden" name="id_utilisateur" value="3">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>

            <tr>
                <td>4</td>
                <td>jordan</td>
                <td>jordan@test.com</td>
                <td>etudiant</td>
                <td>29/01/2026</td>
                <td>
                    <form action="../../source/admin/creer_admin.php" method="post" style="display:inline;">
                        <input type="hidden" name="id_utilisateur" value="4">
                        <button type="submit">Promouvoir admin</button>
                    </form>

                    <form action="../../source/admin/supprimer_user.php" method="post" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                        <input type="hidden" name="id_utilisateur" value="4">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
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
