<?php 
    include ('database.php');

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = trim($_POST['password']);

        $connectUser= $bdd->prepare ('
            SELECT *
            FROM USERS
            WHERE username = :username
        ');

        $connectUser->execute([
            'username' => $username
        ]);

        $user = $connectUser->fetch();
        var_dump($_SESSION);

        if($user) {
            if(password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                $getElements = $bdd->prepare ('
                    SELECT *
                    FROM elements
                    INNER JOIN users_elements ON elements.element_id = users_elements.element_id
                    WHERE users_elements.user_id = :user_id
                ');
                $getElements->execute ([
                    'user_id' => $user['user_id']
                ]);
                // Permet de retourner toutes les lignes sous forme de tableau 
                // PDO//FETCH_ASSOC = constante qui spécifie que les données doivent être retournées sous forme de tableau associatif //
                $_SESSION['element'] = $getElements->fetchAll(PDO::FETCH_ASSOC);

                header('location:index.php');
                exit;
            } else {
                echo "Veuillez saisir un mot de passe valide";
            }
        } else {
            echo "Veuillez saisir un identifiant valide";
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Connection</title>
</head>
<body>
    <?php include ('header.php') ?>

    <section id="connect">
        <div class="container connect_container">
            <h4>CONNECTION</h4>
            <form action="login.php" method="post">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <button type="submit">Access the Academy</button>
            </form>
        </div>
    </section>
</body>
</html>