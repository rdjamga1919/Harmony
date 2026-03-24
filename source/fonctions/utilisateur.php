<?php
function recupererUtilisateurParId(PDO $pdo, int $idUtilisateur): array|false
{
    $sql = "SELECT id_utilisateur, pseudo, nom, prenom, email, niveau_etudes, type_etudes, role, peut_changer_mdp, actif
            FROM utilisateur
            WHERE id_utilisateur = :id_utilisateur
            LIMIT 1";

    $requete = $pdo->prepare($sql);
    $requete->execute([
        ':id_utilisateur' => $idUtilisateur
    ]);

    return $requete->fetch(PDO::FETCH_ASSOC);
}

function pseudoExistePourAutreUtilisateur(PDO $pdo, string $pseudo, int $idUtilisateur): bool
{
    $sql = "SELECT id_utilisateur
            FROM utilisateur
            WHERE pseudo = :pseudo
            AND id_utilisateur != :id_utilisateur
            LIMIT 1";

    $requete = $pdo->prepare($sql);
    $requete->execute([
        ':pseudo' => $pseudo,
        ':id_utilisateur' => $idUtilisateur
    ]);

    return (bool) $requete->fetch(PDO::FETCH_ASSOC);
}

function emailExistePourAutreUtilisateur(PDO $pdo, string $email, int $idUtilisateur): bool
{
    $sql = "SELECT id_utilisateur
            FROM utilisateur
            WHERE email = :email
            AND id_utilisateur != :id_utilisateur
            LIMIT 1";

    $requete = $pdo->prepare($sql);
    $requete->execute([
        ':email' => $email,
        ':id_utilisateur' => $idUtilisateur
    ]);

    return (bool) $requete->fetch(PDO::FETCH_ASSOC);
}

function mettreAJourProfilUtilisateur(PDO $pdo, int $idUtilisateur, array $donnees): bool
{
    $sql = "UPDATE utilisateur
            SET pseudo = :pseudo,
                nom = :nom,
                prenom = :prenom,
                email = :email,
                niveau_etudes = :niveau_etudes,
                type_etudes = :type_etudes
            WHERE id_utilisateur = :id_utilisateur";

    $requete = $pdo->prepare($sql);

    return $requete->execute([
        ':pseudo' => $donnees['pseudo'],
        ':nom' => $donnees['nom'],
        ':prenom' => $donnees['prenom'],
        ':email' => $donnees['email'],
        ':niveau_etudes' => $donnees['niveau_etudes'],
        ':type_etudes' => $donnees['type_etudes'],
        ':id_utilisateur' => $idUtilisateur
    ]);
}

function utilisateurPeutChangerMotDePasse(PDO $pdo, int $idUtilisateur): bool
{
    $sql = "SELECT peut_changer_mdp
            FROM utilisateur
            WHERE id_utilisateur = :id_utilisateur
            LIMIT 1";

    $requete = $pdo->prepare($sql);
    $requete->execute([
        ':id_utilisateur' => $idUtilisateur
    ]);

    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    return $resultat && (int) $resultat['peut_changer_mdp'] === 1;
} // cett fonction existe deux fois ou la mettre

function modifierMotDePasseUtilisateur(PDO $pdo, int $idUtilisateur, string $nouveauMotDePasseHash): bool
{
    $sql = "UPDATE utilisateur
            SET mdp = :mdp
            WHERE id_utilisateur = :id_utilisateur";

    $requete = $pdo->prepare($sql);

    return $requete->execute([
        ':mdp' => $nouveauMotDePasseHash,
        ':id_utilisateur' => $idUtilisateur
    ]);
}
function recupererMotDePasseHashUtilisateur(PDO $pdo, int $idUtilisateur): string|false
{
    $sql = "SELECT mdp
            FROM utilisateur
            WHERE id_utilisateur = :id_utilisateur
            LIMIT 1";

    $requete = $pdo->prepare($sql);
    $requete->execute([
        ':id_utilisateur' => $idUtilisateur
    ]);

    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    return $resultat['mdp'] ?? false;
}


