<?php

session_start();
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../../source/fonctions/authentification.php');
require_once __DIR__ . '/../../source/fonctions/admin.php';
exigerConnexion();
exigerAdmin();

// ici je met la bdd juste pour extraire des infos pas de requtes de traitements reeles
$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');
$requete = $pdo->query("SELECT id_utilisateur, pseudo, email, role, date_inscription FROM utilisateur ORDER BY id_utilisateur DESC");
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

    <?php if(!empty($_SESSION['succes'])): ?>
    <div>
        <?php foreach ($_SESSION['succes'] as $message): ?>
        <p style="color: darkolivegreen;"><?=htmlspecialchars($message)?></p>
        <?php endforeach;?>
    </div>
    <?php unset($_SESSION['succes']); ?>
    <?php endif;?>

    <?php if (!empty($_SESSION['erreurs'])): ?>
    <div>
        <?php foreach ($_SESSION['erreurs'] as $message): ?>
        <p style="color: darkred;"><?=htmlspecialchars($message)?></p>
        <?php endforeach;?>
    </div>
        <?php unset($_SESSION['erreurs']); ?>
    <?php endif;?>

    <section>
        <h2>Liste des utilisateurs</h2>

        <table frame="1" cellpadding="10" cellspacing="0">
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
            <?php if (!empty($utilisateurInfo)): ?>
                <?php foreach ($utilisateurInfo as $utilisateur): ?>
                    <tr>
                        <td><?= htmlspecialchars($utilisateur['id_utilisateur']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['pseudo']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['email']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['role']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['date_inscription']) ?></td>
                        <td>

                        <?php if ($utilisateur['role'] === 'admin'): ?>
                            <p>Déja Admin </p>
                        <?php else: ?>
                            <form action="../../traitement/admin/creer_admin.php" method="post" style="display: inline;" onsubmit="return confirm('Promouvoir cet utilisateur en administrateur ?');">
                                <input type="hidden" name="id_utilisateur" value="<?= htmlspecialchars($utilisateur['id_utilisateur']) ?>">
                                <button type="submit">Promouvoir en admin</button>
                            </form>
                        <?php endif; ?>

                            <?php if ((int) $utilisateur['id_utilisateur'] !== (int)$_SESSION['id_utilisateur']): ?>
                                <form action="../../traitement/admin/supprimer_user.php" method="post" style="display: inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer ce utilisateurs ?')">
                                    <input type="hidden" name="id_utilisateur" value="<?=htmlspecialchars($utilisateur['id_utilisateur']) ?>">
                                    <button type="submit">Supprimer</button>
                                </form>
                            <?php else: ?>
                                <p>Votre compte</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6"> Aucun utilisateurs trouvé.</td>
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
