<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/prices.php');

if($product['pourcentagePromotion'] != null){
     $promotionPrice = calculedPriceWithPromotion($product['prixHT'],$product['pourcentagePromotion']);
}
?>

<article class="card border">
    <header class="img-container">
        <img 
        src="/dev/assets/products/<?=$product['imgRef']?>" 
        alt="product <?=$product['references']?>" 
        class="w-full h-[248px] object-contain"
        >
    </header>
    <div class="flex py-4 px-8 grow">
        <div class="flex flex-col grow">
             <p class="text-xl"><?= $product['nom']?></p>
             <p class="text-sm">#<?= $product['references']?></p>
        </div>
        <div class="flex flex-col">
            <?php if($product['pourcentagePromotion'] != null): ?>
            <h6 class="text-xl text-secondary">
                <?=calculedPriceWithTva($promotionPrice,$product['TVA']) ?>€
            </h6>
            <?php endif; ?>
            <h6 class="text-xl <?= $product['pourcentagePromotion'] ? 'line-through' : '' ?>">
                <?= calculedPriceWithTva($product['prixHT'],$product['TVA'])?>€ TTC
            </h6>
            <p class="text-sm"><?=$product['prixHT']?>€ HT</p>
        </div>
    </div>
    <footer>
        <a class=" block m-2  bg-primary text-white px-8 py-4 flex align-center justify-center" 
           href="/action/addToCart.php?articlesId=<?= $product['articlesId'] ?>"
        >
            Ajouter au panier <span class="material-symbols-outlined ml-4">add</span>
        </a>
    </footer>

    <?php if($product['nouveaute'] == 1):?>
        <h6 class="ml-8 mt-4 text-secondary absolute top-0 left-0">NEW</h6>
    <?php endif; ?>
    <?php if($product['pourcentagePromotion'] != null): ?>
        <h6 class="ml-8 mt-4 text-secondary absolute top-0 left-0"><?=$product['pourcentagePromotion']?>%</h6>
    <?php endif; ?>
   
</article>