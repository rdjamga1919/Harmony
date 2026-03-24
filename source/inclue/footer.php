<?php
require_once(__DIR__ . '/../../config.jordan.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus bien-être</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
<!-- FOOTER -->
<footer class="text-white py-4 mt-5" style="background-color: #c9a0a0;">
    <div class="container text-center">

        <!-- Bouton Déconnexion (couleur pastel) -->
        <?php if(isset($_SESSION['id_utilisateur'])): ?>
            <div class="mb-3">
                <span class="me-3">👋 Bonjour, <?= htmlspecialchars($_SESSION['pseudo'] ?? 'Utilisateur') ?></span>
                <a href="../../source/traitement/deconnexion.php"
                   style="
                       background-color: #ffb7b2;
                       color: #5a3e36;
                       padding: 6px 18px;
                       border-radius: 20px;
                       text-decoration: none;
                       font-weight: 500;
                       font-size: 0.9rem;
                       display: inline-block;
                       transition: background 0.3s;
                   "
                   onmouseover="this.style.backgroundColor='#ffa5a0'"
                   onmouseout="this.style.backgroundColor='#ffb7b2'">
                    Se déconnecter
                </a>
            </div>
        <?php endif; ?>

        <p class="mb-2 fs-5">© 2025 – Tous droits réservés Rosie Djamga - Anaïs Kriegel--Grapain - Onesime Ngakosso-Ibara - Jordan Homere</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>