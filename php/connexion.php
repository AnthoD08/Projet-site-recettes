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
        <h2 class="titre-connexion">Connexion</h2>
        <form action="" method="POST">
            <div class="input-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="inputName" required>
            </div>
            <div class="input-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="inputPassword" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </div>

    <?php
    session_start();
    include './db/connexionBDD.php';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $pseudo = htmlspecialchars($_POST['inputName']);
        $password = htmlspecialchars($_POST['inputPassword']);


        $query = "SELECT * FROM utilisateurs WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['pseudo' => $pseudo]);


        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($user);
        if ($user) {

            if (password_verify($password, $user['mot_de_passe'])) {

                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['id_role'] = $user['id_role'];


                header("Location: profil");
                exit();
            } else {

                echo "<p>Pseudo ou mot de passe incorrect.</p>";
                
            }
        } else {

            echo "<p>Pseudo ou mot de passe incorrect.</p>";
        }
    }
    ?>

</body>

</html>