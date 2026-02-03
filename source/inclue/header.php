<?php
require_once(__DIR__ . '/../../config.php');?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Bien-Être</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR MODERNE -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fs-3 fw-bold" href="#">Harmony</a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#menuBurger">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuBurger">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#accueil">🏠 Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#connexion">🔑 Connexion</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#meslivres">📖 Mes livres</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">📚 Livres</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#ajouter-livre">➕ Ajouter</a></li>
                        <li><a class="dropdown-item" href="#modifier-livre">✏️ Modifier</a></li>
                        <li><a class="dropdown-item" href="#supprimer-livre">🗑️ Supprimer</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">✍️ Auteurs</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#ajouter-auteur">➕ Ajouter</a></li>
                        <li><a class="dropdown-item" href="#modifier-auteur">✏️ Modifier</a></li>
                        <li><a class="dropdown-item" href="#supprimer-auteur">🗑️ Supprimer</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>