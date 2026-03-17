<?php

$host = '127.0.0.1';  // 127.0.0.1 force TCP/IP
$port = 8889;         // Vous changez pour 3306 car vous etes sur windows
$dbname = 'campus_bien_etre';
$user = 'root';
$pass = 'root';           // WAMP vide par défaut, MAMP "root" donc vous laissez vide

try {
    $bdd = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
