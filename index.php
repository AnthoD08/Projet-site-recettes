<?php

// Notre index.php à la racine du site nous sert de routeur :
$maRoute = explode('/', $_GET["route"]);

if (isset($maRoute[0])) {
    
    switch ($maRoute[0]) {
        
        case "": case "accueil":
            include("./php/accueil.php");
            break;

        case "contact":
            include("./php/contact.php");
            break;

        case "connexion":
            include("./php/connexion.php");
            break;

        case "profil.php":
            include("./php/profil.php");
            break;
            
        case "une_recette.php":
            include("./php/une_recette.php");
            break;

        case "recettes":
            if (isset($maRoute[1])) {
                
                switch ($maRoute[1]) {
                    case "": case "toutes":
                        include("./php/toutes_les_recettes.php");
                        break;
                    
                    default:
                        if (is_numeric($maRoute[1])) {
                            $id_recette_demande = $maRoute[1];
                            include("./php/select_one_recette.php");
                        } else {
                            include("./pages/erreur404.html");
                        }
                        break;

                }

            } else {
                include("./php/toutes_les_recettes.php");
            }
            break;

        // Nouveau cas pour les ingrédients
        case "ingredients":
            if (isset($maRoute[1]) && is_numeric($maRoute[1])) {
                $id_recette_demande = $maRoute[1]; // Récupérer l'ID de la recette
                include("./php/ingredients.php"); // Inclure la page des ingrédients
            } else {
                include("./pages/erreur404.html"); // Erreur 404 si l'ID n'est pas valide
            }
            break;

        default:
            include("./pages/erreur404.html");
            break;
    }

} else {
    include("./pages/erreur404.html");
}
?>