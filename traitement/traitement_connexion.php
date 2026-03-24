<?php
session_start();
require_once(__DIR__ . '/../source/bdd/connexion_bdd_jordan.php');

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

$identifiant = trim($_POST['identifiant'] ?? '');
$password = $_POST['password'] ?? '';
$valeurs['identifiant'] = $identifiant;

if (empty($identifiant) || empty($password)) {
    $erreurs[] = "Tous les champs sont obligatoires";
}

if (empty($erreurs)) {
    try {
        $requete = $bdd->prepare("SELECT id_utilisateur, pseudo, email, mdp, role FROM utilisateur WHERE pseudo = :identifiant OR email = :identifiant LIMIT 1");
        $requete->execute([
            "identifiant" => $identifiant,
        ]);
        $utilisateurs = $requete->fetch(PDO::FETCH_ASSOC);

        if (!$utilisateurs || !password_verify($password, $utilisateurs['mdp'])) {
            $erreurs[] = "Identifiant ou mot de passe incorrect";
        } else {
            session_regenerate_id(true);
            $_SESSION['id_utilisateur'] = $utilisateurs['id_utilisateur'];
            $_SESSION['pseudo']         = $utilisateurs['pseudo'];
            $_SESSION['email']          = $utilisateurs['email'];
            $_SESSION['role']           = $utilisateurs['role'];
            $_SESSION['logged_in']      = true;
            $_SESSION['login_time']     = time();
            $_SESSION['succes']         = "Connexion réussie";
            unset($_SESSION['token']);

            if ($utilisateurs['role'] === 'admin') {
                header('Location: ../public/admin/dashboard.php');
                exit;
            }

            header('Location: ../public/forum.php');
            exit;
        }
    } catch (PDOException $e) {
        $erreurs[] = "Erreur lors de la connexion. Veuillez réessayer";
    }
}

$_SESSION['erreurs'] = $erreurs;
$_SESSION['valeurs'] = $valeurs;
header('Location: ../public/connexion.php');
exit;