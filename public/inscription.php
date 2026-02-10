<?php

require_once(__DIR__ . '/../config.php');

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $mail = htmlspecialchars($_POST["mail"]);
    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $etablissement = htmlspecialchars($_POST["etablissement"]);

    // Affichage des données reçues
    $message = "<div style='background-color: #dff0d8; padding: 15px; margin: 10px 0; border: 1px solid #d6e9c6;'>
                <h3>Inscription réussie !</h3>
                <p><strong>Nom:</strong> $nom</p>
                <p><strong>Prénom:</strong> $prenom</p>
                <p><strong>Email:</strong> $mail</p>
                <p><strong>Pseudo:</strong> $pseudo</p>
                <p><strong>Établissement:</strong> $etablissement</p>
                </div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Inscription</title>
</head>
<body>
    <h1>Formulaire d'Inscription</h1>

    <?php echo $message; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <br>

        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <br>

        <div>
            <label for="mail">Email :</label>
            <input type="email" id="mail" name="mail" required>
        </div>
        <br>

        <div>
            <label for="pseudo">Pseudo :</label>
            <input type="text" id="pseudo" name="pseudo" required>
        </div>
        <br>

        <div>
            <label for="etablissement">Nom de l'établissement :</label>
            <input type="text" id="etablissement" name="etablissement" required>
        </div>
        <br>

        <div>
            <input type="submit" value="S'inscrire">
            <input type="reset" value="Effacer">
        </div>
    </form>
</body>
</html>