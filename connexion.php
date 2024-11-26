<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css" />

</head>


<body>

    <?php session_start(); ?>

    <?php include 'navbar.html'; ?>

 

    <form action="" method="POST">
        <label for="variableName"> Nom :</label><br>
        <input type="text" name="inputName" id="variableName" required>
        <br>
        <label for="inputPassword">Mot de passe :</label>
        <input type="password" id="inputPassword" name="inputPassword" required />
        <br>
        <input class="button-connexion" type="submit"></input>
    </form>

    <!-- Traitement PHP des données du formulaire -->

    <?php

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