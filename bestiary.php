<?php 
    include ('database.php');

    $request = $bdd->prepare ('
        SELECT 
            m.monster_id AS monster_id,
            m.monster_name AS monster_name,
            m.description AS description,
            m.image AS monster_image,
            u.user_id AS user_id,
            u.username AS username,
            t.type_id AS type_id,
            t.type_name AS type_name
        FROM 
            monsters as m
        LEFT JOIN 
            users as u ON m.user_id = u.user_id
        LEFT JOIN 
            type as t ON m.type_id = t.type_id
    ');

    $request->execute(array());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Bestiary</title>
</head>
<body>
    <?php include ('header.php')?>
    <section id="bestiary">
        <div class="bestiary_title">
            <h2>The Bestiary</h2>
            <?php if (isset($_SESSION['id'])): ?> 
                <a href='add_monster.php'>Add a new beast</a>
            <?php endif ?>
        </div>
        <div class="container bestiary_container">
 
        <!-- Récuparation REQUEST -->
        <?php while ($data = $request->fetch()) : 
        
        ?>
            <article>
            <div class="img_wrapper">
                <!-- Condition pour afficher l'image, ou l'image générique -->
                <?php if($data['monster_image'] == NULL ): ?>
                    <img src="assets/img/no_image.jpg" alt="Image pour prévenir qu'aucune image n'est présente pour ce monstre">
                <?php else: ?>
                    <img src="assets/creatures/<?= $data['monster_image'] ?>" alt="Image du monstre <?= $data['monster_name'] ?>">
                <?php endif ?>
            </div>
            <div class="beast_title">
                <h4><?= $data['monster_name']  ?></h4>
            </div>
            <div class="beast_content">
                <p><span>Type</span><?= $data['type_name']  ?></p>
                <p><span>Description</span><?= $data['description']  ?></p>
                <p><span>Created by</span><?= $data['username']  ?></p>
            </div>

            <?php if(isset($_SESSION['id'])): ?>
                <?php if($_SESSION['id']==$data['user_id'] || $_SESSION['role'] != NULL): ?>
                <div class="action">
                    <a href="modify.php?id=<?= $data['monster_id']?>">modifier</a>
                    <a href="delete.php?id=<?= $data['monster_id']?>&source=bestiary">supprimer</a>
                </div>
                <?php endif ?>
            <?php endif ?>
            </article>
        <?php endwhile; ?>
        </div>
    </section>
</body>
</html>