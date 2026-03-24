<?php
require_once(ROOT . '/config.php');
$host = '127.0.0.1';          // 127.0.0.1 force TCP/IP
$port = 8889;                 // Vous changez pour 3306 car vous etes sur windows
$dbname = 'campus_bien_etre';
$user = 'root';
$pass = 'root';               // WAMP vide par défaut, MAMP "root" donc vous laissez vide

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Erreur connexion BDD : " . $e->getMessage());
    die("Erreur de connexion à la base de données. Veuillez réessayer plus tard.");
}
return $pdo; //retourner les valeurs
