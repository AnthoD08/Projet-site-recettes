<?php

    // Notre index.php à la racine du site nous sert de routeur :
    // il détermine quel code PHP exécuter en fonction de l'URL

    // 1. On récupère la route (variable $_GET["route"]) dans l'URL
    // et on récupère chaque morceau (séparés par un '/') dans un tableau
    // afin de faciliter le traitement du routage dans l'étape 2.
    $maRoute = explode('/', $_GET["route"]);

    // 2. En fonction de la valeur de la première partie de la route (si elle existe),
    // on détermine quel code PHP exécuter. Si cette première partie n'existe pas, alors
    // si on ne met pas de ifelse, cela va afficher une erreur fatale.

    if ( isset($maRoute[0]) ) {
        
        switch ($maRoute[0]) {
            
            // Dans le cas où $maRoute[0] est vide ou vaut "accueil", on affiche la page d'accueil
            case "": case "accueil":
                include(".//php/accueil.php");
                break;

            // Dans le cas où $maRoute[0] vaut "contact", on affiche la page de contact
            case "contact":
                include(".//php/contact.php");
                break;

            case "connexion":
                include(".//php/connexion.php");
                break;

            case "profil.php":
                include(".//php/profil.php");
                break;
    
            // Dans le cas où $maRoute[0] vaut "recettes", on peut afficher plusieurs pages :
            // - la page d' "accueil" de la partie "recettes" du site qui liste toutes les recettes
            // - la page d'une recette spécifique, après avoir cliqué sur la Card de la recette, depuis la page de toutes les recettes
            // Pour choisir laquelle afficher, on regarde ce qu'il y a dans l'URL, dans la deuxième partie de la route
            case "recettes":

                // Si la deuxième partie de la route n'existe pas (donc pas de '/' derrière "recettes", alors le switch case va afficher une erreur fatale).
                // Ainsi, pour gérer correctement la situation et éviter cettes erreur, on vérifie si la deuxième partie de la route existe avant de l'utiliser.
                // Si elle n'existe pas, cela signifie qu'on aura juste à afficher la page de toutes les recettes.

                if (isset($maRoute[1])) {
                    
                    switch ($maRoute[1]) {

                        // Dans le cas où $maRoute[1] est vide (rien après le '/' dans l'URL) ou vaut "toutes", on affiche la page de toutes les recettes
                        case "": case "toutes":
                            include(".//php/toutes_les_recettes.php");
                            break;
                        
                        // Si la valeur de $maRoute[0] n'est pas dans l'un des "case" ci-dessus, on va traiter les autres possibilités
                        default:

                            // Si la valeur de $maRoute[1] est un nombre entier alors on appelle le script PHP qui affiche la page d'une recette spécifique
                            // Sinon, dans tous les autres cas, il s'agit d'une valeur URL non gérée, donc on affiche alors une erreur 404.

                            if ( is_numeric($maRoute[1]) ) {
                                
                                $id_recette_demande = $maRoute[1];
                                include("./php/select_one_recette.php");

                            } else {
                                include("./pages/erreur404.html");
                            }
                            
                            break;

                    }

                } else {
                    include(".//php/toutes_les_recettes.php");
                }
                
                break;
            
            // Si la valeur de $maRoute[0] n'est pas dans l'un des "case" ci-dessus, on affiche la page d'erreur 404.
            default:
                include("./pages/erreur404.html");
                break;
        }

    } else {
        include("./pages/erreur404.html");
    }
        
?>