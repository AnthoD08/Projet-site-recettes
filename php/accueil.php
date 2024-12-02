<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/styles.css" />
</head>

<body>
    <?php session_start(); ?>

    <?php include('includes/navbar.html'); ?>


    <div class="slider">
        <img src="images/slider.jpg" class="slider-background" alt="" />
        <div class="slider-content">
            <h1>Mon site de cuisine</h1>
            <form class="form-recette" method="POST" action="">
                <label for="nom_recette">Nom de la recette :</label>
                <input type="text" id="nom_recette" name="nom_recette" required>
                <input class="research-button" type="submit" value="Rechercher">
            </form>
        </div>
    </div>


    <?php

    include './db/connexionBDD.php';


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

    <?php
    include('includes/footer.html');
    ?>

</body>

</html>