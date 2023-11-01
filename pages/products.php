<?php
require($_SERVER['DOCUMENT_ROOT'].'/php/db.php');

$products = $mysqli->query('SELECT * FROM articles');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dev/dist/output.css" rel="stylesheet">
    <link 
    href="<?= $_SERVER['DOCUMENT_ROOT'] ?>/dev/css/splide.css" 
    rel="stylesheet"
    />
    <link rel="icon" type="image/png" href="../dev/assets/favicon.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Brico'brac - Produits</title>
</head>
<body>
    <?php require '../templates/header.php'; ?>
        <!-- Slogan -->
        <section class="bg-top-banner  h-[400px] flex items-center mb-16">
            <h2 class="container sm:w-1/2 text-white text-center sm:mt-20 mt-52">Nos Produits</h2>
        </section>
        <?php if ($products->num_rows > 0) : ?>
            <section class="container grid gap-x-2.5 gap-y-8 lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 mb-16 justify-items-center" >
                <?php foreach ($products as $product): ?>
                    <?php require '../templates/card.php'; ?>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    <?php require '../templates/footer.php'; ?>
</body>
</html>