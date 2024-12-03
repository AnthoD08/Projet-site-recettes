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

    <?php
    include './db/connexionBDD.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom_recette = $_POST['nom_recette'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM recettes WHERE nom LIKE :nom");
            $stmt->execute(['nom' => '%' . $nom_recette . '%']);
            $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($recettes) {
                echo "<div class='recettes-container'>";
                foreach ($recettes as $recette) {
                    echo "<div class='recette-card'>";
                    echo "<img src='" . htmlspecialchars($recette['image']) . "' alt='" . htmlspecialchars($recette['nom']) . "' class='recette-image'>";
                    echo "<a href='ingredients.php?id=" . htmlspecialchars($recette['id_recette']) . "'>";
                    echo "<h2 class='recette-title'>" . htmlspecialchars($recette['nom']) . "</h2>";
                    echo "</a>";

                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<div class='recette'><p>Aucune recette trouvée.</p></div>";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    ?>




</body>

</html>