<?php
session_start();
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../source/fonctions/authentification.php');
$pdo = require_once(ROOT . '/source/bdd/connexion_bdd.php');

function verifToken(string $token): bool {
    return isset($_SESSION['token']) && hash_equals($_SESSION['token'], $token);
}

$erreurs = [];
$valeurs = ['identifiant' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/connexion.php');
    exit;
}

if (!verifToken($_POST['csrf_token'] ?? '')) {
    $_SESSION['erreurs'] = ['Erreur de sécurité. Veuillez réessayer.'];
    header('Location: ../public/connexion.php');
    exit;
}

/*$email = trim($_POST['email'] ?? '');//a rajouter et pseudo
$pseudo = trim($_POST['pseudo'] ?? '');*/
$identifiant = trim($_POST['identifiant'] ?? '');
$password = $_POST['password'] ?? '';


$valeurs['identifiant'] = $identifiant; //stocage des données en sessions dans la varibale identifiant

if(empty($identifiant)|| empty($password)){
    $erreurs[] = "Tous les champs sont obligatoires";
}/*elseif (!filter_var($identifiant, FILTER_VALIDATE_EMAIL)) {
    $erreurs['email'] = "Format d'email invalide";
}*/

if (empty($erreurs)){
    try {
        $requete = $pdo->prepare("SELECT id_utilisateur, pseudo, email, mdp, role, actif FROM utilisateur WHERE pseudo = :identifiant OR email = :identifiant LIMIT 1");
        $requete->execute([
            "identifiant" => $identifiant,
        ]);

        $utilisateurs = $requete->fetch(PDO::FETCH_ASSOC); //permet de faire un tableau associatif de donnes

        if (!$utilisateurs || !password_verify($password, $utilisateurs['mdp'])) {
            $erreurs[] = "Identifiant ou mot de passe incorrect";
        }elseif((int)$utilisateurs['actif'] !==1) {
            $erreurs[] = "Votre compte a été désactivé.";
        }else{
            session_regenerate_id(true); //apres la connexion recreer une autre session pour securoité

            $_SESSION['id_utilisateur'] = $utilisateurs['id_utilisateur'];
            $_SESSION['pseudo'] = $utilisateurs['pseudo'];
            $_SESSION['email'] = $utilisateurs['email'];
            $_SESSION['role']= $utilisateurs['role'];
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();
            $_SESSION['succes'] = "Connexion réussie";

            unset($_SESSION['token']);

            if($utilisateurs['role'] === 'admin'){
                header('Location: ../public/admin/dashboard.php');
                exit;
            }
            header('Location: ../public/forum.php');
            exit;
        }
    }catch(PDOException $e){
        error_log("Erreur connexion : " . $e->getMessage());
        $erreurs[] = "Erreurs lors de la connexion. Veuillez réessayer";
    }
}

$_SESSION['erreurs'] = $erreurs;
$_SESSION['valeurs'] = $valeurs;

header('Location: ' . BASE_URL . '/public/connexion.php');
exit;
