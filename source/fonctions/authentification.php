<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);

    session_start();
}

function estConnecte(): bool
{
    if (
        empty($_SESSION['logged_in']) ||
        empty($_SESSION['id_utilisateur']) ||
        empty($_SESSION['login_time'])
    ) {
        return false;
    }

    $timeout = 30 * 60; // 30 minutes

    if (time() - $_SESSION['login_time'] > $timeout) {
        deconnecterUtilisateur();
        return false;
    }

    // rafraîchit l'activité
    $_SESSION['login_time'] = time();

    return true;
}

function exigerConnexion(): void
{
    if (!estConnecte()) {
        $_SESSION['erreurs'] = ["Veuillez vous connecter pour accéder à cette page."];
        header('Location: ' . BASE_URL . '/public/connexion.php');
        exit;
    }
}

function deconnecterUtilisateur(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {//supprimer et detruire la session et les cookies de sessions
        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();

}


