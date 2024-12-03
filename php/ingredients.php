<?php
include './db/connexionBDD.php';

if (isset($_GET['id'])) {
    $recetteId = intval($_GET['id']); // Récupérer l'ID de la recette

    // Préparer une requête pour récupérer les ingrédients en utilisant id_recette
    $stmt = $pdo->prepare("SELECT * FROM ingredients WHERE id_recette = ?");
    $stmt->execute([$recetteId]);
    $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($ingredients) {
        echo "<h1>Ingrédients pour la recette</h1>";
        echo "<ul>";
        foreach ($ingredients as $ingredient) {
            echo "<li>" . htmlspecialchars($ingredient['nom']) . " - " . htmlspecialchars($ingredient['quantite']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun ingrédient trouvé pour cette recette.</p>";
    }
} else {
    echo "<p>ID de recette non spécifié.</p>";
}
?>