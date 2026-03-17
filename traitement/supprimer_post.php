<?php
require_once(__DIR__ . '/../source/bdd/connexion_bdd_jordan.php');

if(isset($_POST['id_poste'])){
    $id = (int)$_POST['id_poste'];
    $stmt = $bdd->prepare("DELETE FROM poste WHERE id_poste = ?");
    $stmt->execute([$id]);
}

header("Location: ../public/forum.php");
exit();
?>