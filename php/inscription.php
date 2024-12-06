<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles/styles.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <?php include('includes/navbar.php'); ?>
    
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">

            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Inscription</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="#" method="POST">
                <div>
                    <label for="Pseudo" class="block text-sm/6 font-medium text-gray-900">Pseudo</label>
                    <div class="mt-2">
                        <input type="pseudo" name="inputName" id="pseudo" autocomplete="pseudo" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Mot de passe</label>
                        <div class="text-sm">
                        </div>
                    </div>
                    <div class="mt-2">
                        <input type="password" name="inputPassword" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-orange-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-orange-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">se connecter</button>
                </div>
            </form>


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

                    // Attribuer le rôle par défaut (id_role = 3)
                    $role_id = 3;  // Rôle "Utilisateur" avec id_role = 3

                    // Insérer l'utilisateur avec le rôle par défaut
                    $insertQuery = "INSERT INTO utilisateurs (pseudo, mot_de_passe, id_role) VALUES (:pseudo, :mot_de_passe, :role_id)";
                    $insertStmt = $pdo->prepare($insertQuery);
                    $insertStmt->execute([
                        'pseudo' => $pseudo,
                        'mot_de_passe' => $mot_de_passe_hache,
                        'role_id' => $role_id
                    ]);

                    echo '<p class="text-center">Inscription réussie ! Vous pouvez maintenant vous connecter.</p>';
                }
            }
            ?>


</body>

</html>