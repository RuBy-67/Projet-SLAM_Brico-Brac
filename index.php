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
require($_SERVER['DOCUMENT_ROOT'].'/php/request.php');

$new_product = getNewArticles();
$promotions =  getArticlesWithPromotion();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dev/dist/output.css" rel="stylesheet">
    <script 
    src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"
    >
    </script>
    <link 
    href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" 
    rel="stylesheet"
    />
    <link 
    href="/dev/css/splide.css" 
    rel="stylesheet"
    />
    <link rel="icon" type="image/png" href="../dev/assets/favicon.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Brico'brac</title>
</head>
<body>
    <?php require($_SERVER['DOCUMENT_ROOT'].'/templates/header.php') ?>
    <!-- Slogan -->
    <section class="bg-top-banner  h-[678px] flex items-center mb-8">
        <h1 class="container lg:w-1/2 text-white text-center xl:mt-0 md:mt-18 mt-52">
            Bienvenue sur Brico’brac ! <br />
            La référence du magasin de bricolage près de chez vous ! 
        </h1>
    </section>
    <?php if ($new_product->num_rows > 0) { ?>
        <section class="mb-16 container flex flex-col items-center">
            <h2 class="mb-8">Les nouveautés</h2>
            <div id="new-slider" class="splide container" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                    <ul class="splide__list">
                    <?php foreach ($new_product as $product) {?>
                        <li class="splide__slide flex justify-center">
                            <?php require($_SERVER['DOCUMENT_ROOT'].'/templates/card.php') ?>
                        </li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </section>
    <?php }; ?>
    <?php if ($promotions->num_rows > 3) { ?> 
        <section class="mb-28 container flex flex-col items-center">
            <h2 class="mb-8">Les incontournables</h2>
            <div id="promotion-slider" class="splide container" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                    <ul class="splide__list">
                    <?php foreach ($promotions as $product) {?>
                        <li class="splide__slide flex justify-center">
                            <?php require($_SERVER['DOCUMENT_ROOT'].'/templates/card.php') ?>
                        </li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </section>
        
    <?php } elseif($promotions->num_rows > 0 & $promotions->num_rows <= 3) { ?>
        <section class=" mb-28 container flex flex-col items-center">
            <h2 class="mb-8">Les incontournables</h2>
            <div class="grid gap-x-2.5 gap-y-8 lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 mb-16 justify-items-center">
                <?php foreach ($promotions as $product) {?>
                    <?php require($_SERVER['DOCUMENT_ROOT'].'/templates/card.php') ?>
                <?php } ?>
            </div>
        </section>
    <?php } ?>
    <?php require($_SERVER['DOCUMENT_ROOT'].'/templates/footer.php') ?>
    <script type="text/javascript" src="/dev/js/slider.js"></script>
</body>
</html>