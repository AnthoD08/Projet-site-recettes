<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Site recettes</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<?php
include 'navbar.html';
?>

<body>



    <div class="slider">
        <img src="images/slider.jpg" class="slider-background" alt="" />
        <div class="slider-content">
            <form method="POST" action="">
                <label class="form-recette " for="nom_recette">Nom de la recette :</label>
                <input type="text" id="nom_recette" name="nom_recette" required>
                <label class="form-recette for=" origine">Origine :</label>
                <select id="origine" name="origine">
                    <option value="">Sélectionnez une origine</option>
                    <option value="origine1">Origine 1</option>
                    <option value="origine2">Origine 2</option>
                    <option value="origine3">Origine 3</option>
                </select>

                <label class="form-recette for=" regime">Régimes :</label>
                <select id="regime" name="regime">
                    <option value="">Sélectionnez un régime</option>
                    <option value="regime1">Régime 1</option>
                    <option value="regime2">Régime 2</option>
                    <option value="regime3">Régime 3</option>
                </select>
                <input class="research-button" type="submit" value="Rechercher">
            </form>
        </div>

    </div>
    </div>



</body>


<?php

include 'connexionBDD.php';


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