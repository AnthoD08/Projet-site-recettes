<?php

    // Script PHP pour aller récupérer les données d'une recette précise (selon son id) en BDD

    // 1. Connexion à la base de données
    require("./db/connexionBDD.php");

    // 2. On formule la requête SQL à laquelle on passe en paramètre l'id de la recette demandée
    $sql = "SELECT * FROM recettes WHERE id_recette = :id_recette";
    $query = $pdo->prepare($sql);

    // 3. On exécute la requête et on va récupérer les données dans une variable $data (ça se fait en deux temps)
    $query->execute(array(
        ":id_recette" => $id_recette_demande
    ));
    $data = $query->fetch();

    // 4. On remet en variables les données qui nous intéressent et on appelle la vue (fichier HTML de la recette)
    if ( $data == true && sizeof($data) > 0 ) {
        $nomRecette = $data["nom"];
        include("./pages/recettes/une_recette.php");
    } else {
        include("./pages/erreur404.html");
    }

?>

