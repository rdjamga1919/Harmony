<?php
require_once(__DIR__ . '/../../config.php');
function est_connecte()
{
    return isset($_SESSION['id_utilisateur']) && !empty($_SESSION['id_utilisateur']);
}

function rediriger_si_deconnecte()
{
    if (!est_connecte()) {
        header("Location: " . ROOT_URL . "/pages/connexion.php");
        exit;
    }
}
