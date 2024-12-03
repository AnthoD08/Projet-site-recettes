<!DOCTYPE html>
<html lang="en">
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

// Vérifiez si l'ID de recette est passé par le routeur
if (isset($id_recette_demande)) {
    $recetteId = intval($id_recette_demande); // Récupérer l'ID de la recette

    // Préparer une requête SQL avec une jointure pour récupérer les ingrédients associés à la recette
    try {
        // Requête avec jointure entre recettes_ingredients et ingredients
        $stmt = $pdo->prepare("
            SELECT ingredients.nom AS ingredient_nom, ingredients.id_ingredient
            FROM ingredients
            JOIN recettes_ingredients ON recettes_ingredients.id_ingredient = ingredients.id_ingredient
            WHERE recettes_ingredients.id_recette = ?");
        $stmt->execute([$recetteId]);

        // Récupérer les ingrédients associés à la recette
        $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($ingredients) {
            echo "<h1>Ingrédients pour la recette</h1>";
            echo "<div class='ingredients-container'>"; // Conteneur des cartes d'ingrédients
            foreach ($ingredients as $ingredient) {
                echo "<div class='ingredient-card'>";
                echo "<h3>" . htmlspecialchars($ingredient['ingredient_nom']) . "</h3>";
                echo "</div>"; // Fermeture de la carte de l'ingrédient
            }
            echo "</div>"; // Fermeture du conteneur des cartes
        } else {
            echo "<p>Aucun ingrédient trouvé pour cette recette.</p>";
        }
    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }
} else {
    echo "<p>ID de recette non spécifié.</p>";
}
?>

</body>
</html>