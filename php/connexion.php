<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/styles.css" />

</head>


<body>


    <?php include('includes/navbar.html'); ?>


    <div class="container">
        <h2 class="titre-connexion">Connexion</h2>
        <form action="" method="POST">
            <div class="input-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="inputName" required>
            </div>
            <div class="input-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="inputPassword" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </div>
    <!-- Traitement PHP des données du formulaire -->

    <?php

    session_start();
    $bonPseudo = "anthony";
    $bonMotDePasse = "123";


    // Si le formulaire a été envoyé
    if ($_POST) {

        // Vérification du pseudo
        if (isset($_POST["inputName"]) && !empty($_POST["inputName"])) {
            $_POST["inputName"] = htmlspecialchars($_POST["inputName"]);
        }

        // Vérification du mot de passe
        if (isset($_POST["inputPassword"]) && !empty($_POST["inputPassword"])) {
            $_POST["inputPassword"] = htmlspecialchars($_POST["inputPassword"]);
        }

        // Vérification que le pseudo et le mdp sont les bons
        if ($_POST["inputName"] == $bonPseudo && $_POST["inputPassword"] == $bonMotDePasse) {
            $_SESSION["pseudo"] = $_POST["inputName"];
            header("Location: profil.php");
        } else {
            echo "Pseudo ou mot de passe incorrects !";
        }
    }


    ?>

</body>

</html>