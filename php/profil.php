<?php
session_start();  // Démarrage de la session au tout début
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>

    <?php include('includes/navbar.php'); ?>

    <?php
    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION["pseudo"]) || empty($_SESSION["pseudo"])) {
        header("Location: connexion");
        exit();
    }

    // Dossier pour stocker les photos téléchargées
    $uploadDir = "uploads/";
    // Nom par défaut pour la photo de profil
    $defaultProfilePic = "profile.jpg"; // Image par défaut, à ajouter dans le dossier uploads

    // Si un fichier a été téléchargé, traiter l'image
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {

        // Récupère les informations du fichier
        $fileName = basename($_FILES['profile_pic']['name']);
        $fileName = $_SESSION["pseudo"] . ".jpg"; // Renommer l'image avec le pseudo de l'utilisateur
        $targetFile = $uploadDir . $fileName;
        $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        // Vérifie que le fichier est une image
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($fileType), $allowedTypes)) {

            // Déplace le fichier dans le dossier uploads
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
                // Enregistre le chemin de l'image dans la session
                $_SESSION['profile_pic'] = $targetFile;
            } else {
                $error = "Erreur lors du téléchargement de l'image.";
            }
        } else {
            $error = "Seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
        }
    }

    // Vérifie si une photo de profil personnalisée est stockée dans la session
    if (isset($_SESSION['profile_pic']) && !empty($_SESSION['profile_pic'])) {
        $profilePic = $_SESSION['profile_pic'];
    } else {
        // Sinon, utilise l'image par défaut
        $profilePic = $uploadDir . $defaultProfilePic;
    }
    ?>

    <h1>Bonjour <?php echo htmlspecialchars($_SESSION["pseudo"]); ?> !</h1>

    <!-- Affichage de la photo de profil actuelle -->
    <div class="img-profil">
        <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Photo de profil" style="width: 150px; height: 150px; object-fit: cover;">
    </div>

    <!-- Formulaire de téléchargement de la nouvelle photo de profil -->
    <form class="form-profil" action="" method="post" enctype="multipart/form-data">
        <label for="profile_pic">Choisir une nouvelle photo de profil :</label>
        <input type="file" name="profile_pic" id="profile_pic" required>
        <button type="submit">Mettre à jour la photo</button>
    </form>

    <br><br><br>

    <a href="deconnexion">Se déconnecter</a>

</body>

</html>
