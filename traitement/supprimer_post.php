<?php
session_start();
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../source/fonctions/authentification.php');
$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');

if(isset($_POST['id_poste'])){
    $id = (int)$_POST['id_poste'];
    $stmt = $pdo->prepare("DELETE FROM poste WHERE id_poste = ?");
    $stmt->execute([$id]);
}

header("Location: ../public/forum.php");
exit();
?>