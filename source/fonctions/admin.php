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
function supprimerUtilisateur(PDO $pdo, int $idUtilisateur): bool
{
    $sql = "DELETE FROM utilisateur WHERE id_utilisateur = :id_utilisateur ";
    $requete = $pdo->prepare($sql);
    return $requete->execute([
        ':id_utilisateur' => $idUtilisateur
    ]);

}