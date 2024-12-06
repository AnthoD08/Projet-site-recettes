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

    <?php include('includes/navbar.php'); ?>


    <div class="slider">
        <img src="images/slider.jpg" class="slider-background" alt="" />
        <div class="slider-content">
            <h1>Mon site de cuisine</h1>
            <form class="form-recette" method="POST" action="une_recette">
                <label for="nom_recette">Nom de la recette :</label>
                <input type="text" id="nom_recette" name="nom_recette" placeholder="Entrez un nom de recette" required>
                <input class="research-button" type="submit" value="Rechercher">
            </form>
        </div>
    </div>


    <?php
    include('includes/footer.html');
    ?>


</body>
</html>