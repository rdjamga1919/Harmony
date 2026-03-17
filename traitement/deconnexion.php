<?php
session_start();
require_once(__DIR__ . '/../source/fonctions/authentification.php');

$_SESSION = [];

deconnecterUtilisateur();
echo "Vous êtes bien deconnecter";

// Redirection vers la page de connexion
header('Location: ../public/connexion.php');
exit;

