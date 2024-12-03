<?php

    // Une déconnexion utilisateur, ce n'est rien d'autre que
    // la destruction des variables de session puis on redirige vers la page d'accueil
    session_start();
    session_destroy();
    header("Location: accueil");

?>