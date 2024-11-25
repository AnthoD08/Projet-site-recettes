<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Site recettes</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <h1>Site de Recettes</h1>
    <form method="POST" action="">
        <label for="nom_recette">Nom de la recette :</label>
        <input type="text" id="nom_recette" name="nom_recette" required>
        <input type="submit" value="Rechercher">
    </form>
</body>


<?php

include 'connexion.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom_recette = $_POST['nom_recette'];


    try {
        $stmt = $pdo->prepare("SELECT * FROM recettes WHERE nom LIKE :nom");
        $stmt->execute(['nom' => '%' . $nom_recette . '%']);
        $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if ($recettes) {
            foreach ($recettes as $recette) {
                echo "<div class='recette'>";
                echo "<img src='" . htmlspecialchars($recette['image']) . "' alt='" . htmlspecialchars($recette['nom']) . "'>";
                echo "<h2>" . htmlspecialchars($recette['nom']) . "</h2>";
                echo "<p>" . htmlspecialchars($recette['description']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<div class='recette'><p>Aucune recette trouvée.</p></div>";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>


</html>