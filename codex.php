<?php 
    include ('database.php');

    $request = $bdd->prepare ('
        SELECT
            s.spell_id as spell_id,
            s.spell_name as spell_name,
            s.description as description,
            s.image as image,
            u.user_id as user_id,
            u.username as username,
            e.element_id as element_id,
            e.element_name as element_name
        FROM
            spells as s
        LEFT JOIN
            users as u ON s.user_id = u.user_id
        LEFT JOIN
            elements as e ON s.element_id = e.element_id
    ');

    $request->execute([]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Codex</title>
</head>
<body>
    <?php include ('header.php')?>
    <section id="codex">
        <div class="codex_title">
            <h2>The Codex</h2>
            <?php if (isset($_SESSION['id'])): ?> 
                <a href='add_spell.php'>Add a new spell</a>
            <?php endif ?>
        </div>
        <div class="container codex_container">
 
        <!-- Récuparation REQUEST -->
        <?php while ($data = $request->fetch()) : 
        
        ?>
            <article>
            <div class="img_wrapper">
                <!-- Condition pour afficher l'image, ou l'image générique -->
                <?php if($data['image'] === NULL ): ?>
                    <img src="assets/img/no_image.jpg" alt="Image pour prévenir qu'aucune image n'est présente pour ce monstre">
                <?php else: ?>
                    <img src="assets/sorts/<?= $data['image'] ?>" alt="Image du sort <?= $data['spell_name'] ?>">
                <?php endif ?>
            </div>
            <div class="spell_title">
                <h4><?= $data['spell_name']  ?></h4>
            </div>
            <div class="spell_content">
                <p><span>Spell</span><?= $data['spell_name']  ?></p>
                <p><span>Description</span><?= $data['description']  ?></p>
                <p><span>Element</span><?= $data['element_name']  ?></p>
                <p><span>Imported by</span><?= $data['username']  ?></p>
            </div>

            <?php if(isset($_SESSION['id'])): ?>
                <?php if($_SESSION['id']==$data['user_id'] || $_SESSION['role'] != NULL): ?>
                <div class="action">
                    <a href="modify.php?id=<?= $data['spell_id']?>">modifier</a>
                    <a href="delete.php?id=<?= $data['spell_id']?>&source=codex">supprimer</a>
                </div>
                <?php endif ?>
            <?php endif ?>
            </article>
        <?php endwhile; ?>
        </div>
    </section>
</body>
</html>