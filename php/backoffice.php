<?php
session_start();

// Vérifie si l'utilisateur est connecté et a le rôle 1 (Admin)
if (!isset($_SESSION['pseudo']) || $_SESSION['id_role'] != 1) {
    header('Location: connexion.php');
    exit();
}

include './db/connexionBDD.php';

// Variables pour le formulaire
$nom = $description = $image = $temps_preparation = $id_theme = $id_difficulte = '';

// Gestion du téléchargement de l'image
$uploadDir = "uploads/images_recettes/";
$imageError = "";
$targetFile = "";
$messageConfirmation = "";
// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $temps_preparation = (int) $_POST['temps_preparation'];
    $id_theme = (int) $_POST['id_theme'];
    $id_difficulte = (int) $_POST['id_difficulte'];
    $id_utilisateur = $_SESSION['id_utilisateur'];  // L'utilisateur connecté

    // Vérification de l'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileName = basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;
        $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        // Vérifie que le fichier est bien une image
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($fileType), $allowedTypes)) {
            // Déplace le fichier dans le dossier 'uploads'
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $image = $targetFile;
            } else {
                $imageError = "Erreur lors du téléchargement de l'image.";
            }
        } else {
            $imageError = "Seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
        }
    } else {
        $image = null; // Si aucune image n'est uploadée, on garde une valeur nulle
    }

    // Insertion dans la base de données
    if (empty($imageError)) {
        try {
            // Préparation de la requête d'insertion
            $query = "INSERT INTO recettes (nom, description, image, temps_preparation, id_theme, id_difficulte, id_utilisateur)
                      VALUES (:nom, :description, :image, :temps_preparation, :id_theme, :id_difficulte, :id_utilisateur)";
            $stmt = $pdo->prepare($query);

            // Exécution de la requête
            $stmt->execute([
                'nom' => $nom,
                'description' => $description,
                'image' => $image,
                'temps_preparation' => $temps_preparation,
                'id_theme' => $id_theme,
                'id_difficulte' => $id_difficulte,
                'id_utilisateur' => $id_utilisateur
            ]);

            $messageConfirmation = "Recette ajoutée avec succès!";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice - Ajouter une recette</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include('includes/navbar.php'); ?>
    
    <h1>Ajouter une recette</h1>

    <?php if ($messageConfirmation): ?>
        <div style="color: green; font-weight: bold;">
            <?php echo $messageConfirmation; ?>
        </div>
    <?php endif; ?>

    <form action="backoffice" method="POST" enctype="multipart/form-data">
        <div>
            <label for="nom">Nom de la recette :</label>
            <input type="text" name="nom" id="nom" required value="<?php echo $nom; ?>" />
        </div>

        <div>
            <label for="description">Description :</label>
            <textarea name="description" id="description" required><?php echo $description; ?></textarea>
        </div>

        <div>
            <label for="temps_preparation">Temps de préparation (en minutes) :</label>
            <input type="number" name="temps_preparation" id="temps_preparation" required value="<?php echo $temps_preparation; ?>" />
        </div>

        <div>
            <label for="id_theme">Thème :</label>
            <select name="id_theme" id="id_theme">
                <option value="">Sélectionner un thème</option>
                <!-- Vous devrez ajouter ici les options des thèmes depuis la base de données -->
                <?php
                // Récupération des thèmes depuis la base de données
                $themes = $pdo->query("SELECT * FROM themes")->fetchAll();
                foreach ($themes as $theme) {
                    echo "<option value='" . $theme['id_theme'] . "' " . ($theme['id_theme'] == $id_theme ? 'selected' : '') . ">" . $theme['nom'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div>
            <label for="id_difficulte">Difficulté :</label>
            <select name="id_difficulte" id="id_difficulte" required>
                <option value="">Sélectionner une difficulté</option>
                <!-- Vous devrez ajouter ici les options de difficulté depuis la base de données -->
                <?php
                // Récupération des difficultés depuis la base de données
                $difficultes = $pdo->query("SELECT * FROM difficulte")->fetchAll();
                foreach ($difficultes as $difficulte) {
                    echo "<option value='" . $difficulte['id_difficulte'] . "' " . ($difficulte['id_difficulte'] == $id_difficulte ? 'selected' : '') . ">" . $difficulte['nom'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div>
            <label for="image">Image :</label>
            <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/gif" />
        </div>

        <div>
            <button type="submit">Ajouter la recette</button>
        </div>
    </form>

</body>
</html>
