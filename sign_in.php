<?php 
    include ('database.php');
    var_dump($_POST);

    if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmPassword']) && isset($_POST['element1'])) {
        // Récupère les données envoyées par l'utilisateur + securisation
        $email = htmlspecialchars($_POST['email']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $confirmPassword = htmlspecialchars($_POST['confirmPassword']);
        $element1 = $_POST['element1'];
        if (isset($_POST['element2']) && $_POST['element2'] != '') {
            $element2 = $_POST['element2'];
        } else {
            $element2 = null;
        }

        // Vérifie si le mot de passe et la confirmation du mot de passe sont identiques
        if ($password != $confirmPassword) {
            echo "Veuillez saisir un mot de passe identique";
        } else {
            // Si les mots de passe sont ok = vérification que mail et nom d'utilisateur n'existe pas déjà dans la database
            $checkUser = $bdd->prepare ('
                SELECT *
                FROM users
                WHERE email = :email OR username = :username
            ');

            // Exécute la requête
            $checkUser->execute([
                'email' => $email,
                'username' => $username
            ]);

            // Si un utilisateur existe déjà avec ce mail ou ce nom = message d'erreur
            if ($checkUser->rowCount() > 0) {
                echo "Ce nom d'utilisateur ou cette adresse email existe déjà";
            } else {
                // Si aucune correspondance on crypte le mot de passe avant d'enregistrer
                $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

                // Prépare requête pour insérer données dans database
                $insertUser = $bdd->prepare ('
                    INSERT INTO users (email, username, `password`)
                    VALUES (:email, :username, :password)
                ');

                $insertUser->execute([
                    'email' => $email,
                    'username' => $username,
                    'password' => $hashedPassword
                ]);

                // Récupère la dernière entrée ID 
                $user_id = $bdd ->lastInsertId();

                // Prépare requête pour users_elements
                // Fait le lien entre user_id et element_id
                $insertElements = $bdd->prepare ('
                    INSERT INTO users_elements (user_id, element_id)
                    VALUES (:user_id, :element_id)
                ');

                // Exécute la requête pour element 2
                // $user_id est l'ID utilisateur nouvellement créé (à voir si vraiment fonctionnel à l'usage .. LUDO ?????)
                $insertElements->execute([
                    'user_id' => $user_id,
                    'element_id' =>$element1
                ]);

                // Si element 2 a été fourni et n'est pas vide = Exécute la requête pour element 2 
                if ($element2) {
                    $insertElements->execute([
                        'user_id' => $user_id,
                        'element_id' => $element2
                    ]);
                }


                // On redirige vers la page de connexion après l'enregistrement
                header ('location: sign_in.php');
                exit;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Sign In</title>
</head>
<body>
    <?php include ('header.php') ?>

    <section id="connect" class="signIn">
        <div class="container connect_container">
            <h4>CREATE AN ACCOUNT</h4>
            <form action="sign_in.php" method="post">
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                <div class="elementsChoice">
                    <select id="element1" name="element1">
                        <option value="" disabled selected>Select your main element</option>

                        <!-- Récupère les éléments dans la database -->
                        <?php
                            $elementRequest = $bdd->prepare ('
                                SELECT *
                                FROM elements
                            ');

                            $elementRequest->execute([]);

                            while ($row = $elementRequest->fetch()) {
                                $element_id = $row['element_id'];
                                $element_name = $row['element_name'];

                                echo '<option value="' . $element_id . '">' . $element_name . '</option>';
                            }
                        ?>
                    </select>
                    <select id="element2" name="element2">
                        <option value="" disabled selected>Select your secondary element</option>

                        <!-- Récupère les éléments dans la database -->
                        <?php
                            $elementRequest = $bdd->prepare ('
                                SELECT *
                                FROM elements
                            ');

                            $elementRequest->execute([]);

                            while ($row = $elementRequest->fetch()) {
                                $element_id = $row['element_id'];
                                $element_name = $row['element_name'];

                                echo '<option value="' . $element_id . '">' . $element_name . '</option>';
                            }
                        ?>
                        <option value="">Aucun</option>
                    </select>
                </div>
                <button type="submit">Embark on your wizard's journey</button>
            </form>
        </div>
    </section>
</body>
</html>