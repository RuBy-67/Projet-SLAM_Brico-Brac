<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/db.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/request.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/prices.php');

$article = getArticleInfos($_GET['articlesId'])[0];
$new_product = getNewArticles();

if($article['pourcentagePromotion'] != null){
     $priceWithReduction = calculedPriceWithPromotion($article['prixHT'],$article['pourcentagePromotion']);
}
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
    <title>Brico'brac - <?= $article['nom'] ?></title>
</head>
<body>
    <?php require '../templates/header.php'; ?>
        <!-- Slogan -->
        <section class="bg-top-banner  h-[400px] flex items-center mb-16">
            <div class="container sm:w-1/2 flex flex-col sm:mt-40 mt-56">
                <h2 class=" text-white text-center "><?= $article['nom'] ?></h2>
                <p class="text-white text-center">#<?= $article['references'] ?></p>
            </div>
        </section>
        <section class="container flex sm:flex-row flex-col mb-8 gap-8">
            <img 
            src="/dev/assets/products/<?=$article['imgRef']?>" 
            alt="product <?=$article['references']?>" 
            class="sm:w-1/2 w-full h-[248px] object-contain"
            > 
            <div class="sm:w-1/2 flex flex-col mx-2">
                <?php if($article['pourcentagePromotion'] != null): ?>
                    <div class="flex lg:flex-row flex-col mb-4">
                        <div class="mr-8 mb-4">
                            <p>Prix HT après remise : <?= $priceWithReduction ?>€</p>
                            <p>Prix TTC après remise : <?= calculedPriceWithTva($priceWithReduction ,$article['TVA'])?>€</p>
                        </div>
                        <div>
                            <p>Prix HT avant remise : <?= $article['prixHT']?>€</p>
                            <p>Prix TTC avant remise : <?= calculedPriceWithTva($article['prixHT'],$article['TVA'])?>€</p>
                        </div>
                        </div>
                <?php else :?>
                    <div class="mb-4">
                        <p>Prix HT :<?= $article['prixHT']?>€</p>
                        <p>Prix TTC :<?= calculedPriceWithTva($article['prixHT'],$article['TVA'])?>€</p>
                    </div>
                <?php endif; ?>
                <?php if(isset($article['descriptions'])):?>
                    <p class="mb-4"><?=$article['descriptions']?></p>
                <?php else :?>
                    <p class="mb-4">Il n'y a pas de description pour cet article</p>
                <?php endif; ?>
                
                <a class=" block   bg-primary text-white px-8 py-4 flex align-center justify-center" 
                href="/action/addToCart.php?articlesId=<?= $article['articlesId'] ?>"
                >
                    Ajouter au panier <span class="material-symbols-outlined ml-4">add</span>
                </a>
            </div>
        </div>
        </section>
        <section class="mb-16 container flex flex-col items-center">
            <h4 class="mb-8">Ces articles peuvent vous intéresser</h4>
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
    <?php require '../templates/footer.php'; ?>
    <script type="text/javascript" src="/dev/js/slider.js"></script>
</body>
</html>