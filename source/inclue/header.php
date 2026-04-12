<?php
require_once(__DIR__ . '/../../config.jordan.php');?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Bien-Être</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="header.css">
</head>
<body>

<!-- NAVBAR MODERNE -->
<nav class="navbar navbar-expand-lg text-white py-4" style="background-color: #c9a0a0;">
    <div class="container-fluid">
        <a class="navbar-brand fs-3 fw-bold text-white" href="#">Harmony</a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#menuBurger">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuBurger">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#accueil">🏠 Ressources </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#meslivres">📖 Forum </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#connexion">🔑 Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#meslivres">📞 Contact </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>