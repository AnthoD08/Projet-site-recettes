<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire PHP</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>

    <?php include('includes/navbar.html'); ?>
    <?php

    session_start();
    $_SESSION["pseudo"] = "anthony";

    // Dossier pour stocker les photos téléchargées
    $uploadDir = "uploads/";
    // Nom par défaut pour la photo de profil
    $defaultProfilePic = "profile.png"; // Image par défaut, à ajouter dans le dossier uploads



    // Vérifie si un fichier a été téléchargé via le formulaire
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {

        // Récupère les informations du fichier
        $fileName = basename($_FILES['profile_pic']['name']);

        // Ici, on souhaite renommer le fichier avec le pseudo de l'utilisateur
        $fileName = $_SESSION["pseudo"] . ".jpg";

        $targetFile = $uploadDir . $fileName;
        $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        // Vérifie que le fichier est une image
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($fileType), $allowedTypes)) {

            // Déplace le fichier dans le dossier uploads
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
                // Définit la nouvelle image de profil
                $profilePic = $targetFile;
            } else {
                $error = "Erreur lors du téléchargement de l'image.";
            }
        } else {
            $error = "Seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
        }
    } else {

        // Utilise l'image par défaut si aucune image n'a été téléchargée
        $profilePic = $uploadDir . $defaultProfilePic;
    }

    ?>


    <!-- Sécurité : on redirige vers la page de formulaire si on n'est pas connecté -->
    <?php
    if (!isset($_SESSION["pseudo"]) || empty($_SESSION["pseudo"])) {
        header("Location: connexion.php");
    }
    echo ("Bonjour " . $_SESSION["pseudo"] . " ! <br><br>");
    ?>


    <!-- Affichage de la photo de profil actuelle -->
    <div>
        <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Photo de profil" style="width: 150px; height: 150px; object-fit: cover;">
    </div>

    <!-- Formulaire de téléchargement de la nouvelle photo de profil -->
    <div class="form-profil">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="profile_pic">Choisir une nouvelle photo de profil :</label>
            <input type="file" name="profile_pic" id="profile_pic" required>
            <button type="submit">Mettre à jour la photo</button>
        </form>
    </div>


    <br><br><br>

    <a href="deconnexion.php">Se déconnecter</a>



</body>

</html>