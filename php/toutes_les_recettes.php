<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <base href="http://localhost/projets/Projet-site-recettes/">
  <link rel="stylesheet" href="styles/styles.css" />
</head>

<body>

  <?php include('includes/navbar.php'); ?>

  <h2>Toutes les recettes</h2>


  <?php
  include './db/connexionBDD.php';

  try {

    $stmt = $pdo->query("SELECT * FROM recettes");
    $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($recettes) {
      echo "<div class='recettes-container'>";
      foreach ($recettes as $recette) {
        echo "<div class='recette-card'>";
        echo "<img src='" . htmlspecialchars($recette['image']) . "' alt='" . htmlspecialchars($recette['nom']) . "' class='recette-image'>";
        echo ("<a href='ingredients/" . htmlspecialchars($recette['id_recette']) . "' class='lien-recette'>Voir la recette</a>");
        echo "<h2 class='recette-title'>" . htmlspecialchars($recette['nom']) . "</h2>";
        echo "<p class='recette-description'>" . htmlspecialchars($recette['description']) . "</p>";
        echo "</div>";
      }
      echo "</div>";
    } else {
      echo "<div class='recette'><p>Aucune recette trouvée.</p></div>";
    }
  } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }

  ?>


  <?php
  include('includes/footer.html');
  ?>



</body>

</html>