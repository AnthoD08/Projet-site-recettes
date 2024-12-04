<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles/styles.css" />
</head>

<body>

    <?php include('includes/navbar.html'); ?>

    <div class="container">
        <h2 class="titre-connexion">Inscription</h2>
        <form action="" method="POST">
            <div class="input-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="inputName" required>
            </div>
            <div class="input-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="inputPassword" required>
            </div>
            <button type="submit">S'inscrire</button>
        </form>
    </div>

    <?php

    session_start();
    include './db/connexionBDD.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $pseudo = htmlspecialchars($_POST['inputName']);
        $password = htmlspecialchars($_POST['inputPassword']);

        // Vérifier si le pseudo existe déjà
        $query = "SELECT * FROM utilisateurs WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['pseudo' => $pseudo]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "<p>Ce pseudo est déjà pris. Veuillez en choisir un autre.</p>";
        } else {
            // Hacher le mot de passe
            $mot_de_passe_hache = password_hash($password, PASSWORD_DEFAULT);

            // Insérer l'utilisateur dans la base de données
            $insertQuery = "INSERT INTO utilisateurs (pseudo, mot_de_passe) VALUES (:pseudo, :mot_de_passe)";
            $insertStmt = $pdo->prepare($insertQuery);
            $insertStmt->execute(['pseudo' => $pseudo, 'mot_de_passe' => $mot_de_passe_hache]);

            echo "<p>Inscription réussie ! Vous pouvez maintenant vous connecter.</p>";
        }
    }
    ?>

</body>

</html>