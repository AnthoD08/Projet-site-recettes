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
                echo "<div class='une-recette-container'>";
                foreach ($recettes as $recette) {
                    echo "<div class='une-recette-card'>";
                    echo "<img src='" . htmlspecialchars($recette['image']) . "' alt='" . htmlspecialchars($recette['nom']) . "' class='recette-image'>";
                    echo ("<a href='ingredients/" . htmlspecialchars($recette['id_recette']) . "' class='lien-recette'>Voir la recette</a>");
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



    <?php
    include('includes/footer.html');
    ?>



</body>

</html>