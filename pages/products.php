<?php
if (!session_id()) {
    session_start();
}
if (isset($_SESSION['group'])) {
    $usergroup = $_SESSION['group'];
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
if (isset($_SESSION['surname'])) {
    $surname =  $_SESSION['surname'];
}
require_once($_SERVER['DOCUMENT_ROOT'].'/Projet-SLAM_Brico-Brac/php/db.php');

$products = $mysqli->query('SELECT * FROM articles');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/Projet-SLAM_Brico-Brac/dev/dist/output.css" rel="stylesheet">
    <link 
    href="<?= $_SERVER['DOCUMENT_ROOT'] ?>/Projet-SLAM_Brico-Brac/dev/css/splide.css" 
    rel="stylesheet"
    />
    <link rel="icon" type="image/png" href="/Projet-SLAM_Brico-Brac/dev/assets/favicon.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Brico'brac - Produits</title>
</head>
<body>
<?php require($_SERVER['DOCUMENT_ROOT'].'/Projet-SLAM_Brico-Brac/templates/header.php') ?>
        <!-- Slogan -->
        <section class="bg-top-banner  h-[400px] flex items-center mb-16">
            <h2 class="container sm:w-1/2 text-white text-center sm:mt-20 mt-52">Nos Produits</h2>
        </section>
        <?php if ($products->num_rows > 0) : ?>
            <section class="container grid gap-x-2.5 gap-y-8 lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 mb-16 justify-items-center" >
                <?php foreach ($products as $product): ?>
                    <?php require($_SERVER['DOCUMENT_ROOT'].'/Projet-SLAM_Brico-Brac/templates/card.php') ?>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
        <?php require($_SERVER['DOCUMENT_ROOT'].'/Projet-SLAM_Brico-Brac/templates/footer.php') ?>
</body>
</html>