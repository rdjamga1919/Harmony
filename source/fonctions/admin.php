<?php
function estAdmin(): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
function exigerAdmin(): void
{
    if (!estAdmin()) {
        $_SESSION['erreurs'] = ["Accès refusé."];
        header('Location: ../connexion.php');
        exit;
    }
}
function promouvoirEnAdmin(PDO $pdo, int $idUtilisateur): bool
{
    $sql = "UPDATE utilisateur SET role = 'admin' WHERE id_utilisateur = :id_utilisateur AND role != 'admin'";
    $requete = $pdo->prepare($sql);
    return $requete->execute([
        ':id_utilisateur' => $idUtilisateur

    ]);
}
function bloquerUtilisateur(PDO $pdo, int $idUtilisateur): bool
{
    $motDePasseTemporaire = bin2hex(random_bytes(16));
    $motDePasseHash = password_hash($motDePasseTemporaire, PASSWORD_DEFAULT);

    $sql = "UPDATE utilisateur SET mdp = :mdp, peut_changer_mdp = 0, actif = 0 WHERE id_utilisateur = :id_utilisateur";

    $requete = $pdo->prepare($sql);

    return $requete->execute([
        ':mdp' => $motDePasseHash,
        ':id_utilisateur' => $idUtilisateur
    ]);
}
function supprimerCommentaire(PDO $pdo,int $idCommentaire) : bool
{
    $sql = "DELETE FROM commentaire WHERE id_commentaire = :id_commentaire";
    $requete = $pdo->prepare($sql);
    return $requete->execute([
        ':id_commentaire' => $idCommentaire
    ]);
}

function utilisateurPeutChangerMotDePasse(PDO $pdo, int $idUtilisateur): bool
{
    $sql = "SELECT peut_changer_mdp FROM utilisateur  WHERE id_utilisateur = :id_utilisateur LIMIT 1";
    $requete = $pdo->prepare($sql);
    $requete->execute([':id_utilisateur' => $idUtilisateur]);

    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    return $resultat && (int)$resultat['peut_changer_mdp'] === 1;
}

function supprimerPost(PDO $pdo, int $idPoste) : bool
{
    $sql = "DELETE FROM poste WHERE id_poste = :id_poste";
    $requete = $pdo->prepare($sql);
    return $requete->execute([
        ':id_poste'=> $idPoste
    ]);
}