<?php 
if($cartItem['pourcentagePromotion'] != null){
$priceWithReduction = calculedPriceWithPromotion($cartItem['prixHT'],$cartItem['pourcentagePromotion']);
}
?>
<li class="grid lg:grid-cols-7 lg:grid-rows-1 grid-cols-2 grid-rows-3 gap-4 mb-4">
    <div class="col-span-2 row-start-1">
        <p class="font-bold">Produit : <?= $cartItem['nom']?></p>
        <p>Référence :<?= $cartItem['references']?></p>
    </div>
    <div 
    class="lg:col-span-3 lg:col-start-3 lg:row-start-1 col-span-2 row-start-2 <?php if($cartItem['pourcentagePromotion'] != null): ?>grid grid-cols-2<?php endif;?>"
    >
        <?php if($cartItem['pourcentagePromotion'] != null): ?>
            <div class="mr-8">
                <p>Prix HT après remise : <?= $priceWithReduction ?>€</p>
                <p>Prix TTC après remise : <?= calculedPriceWithTva($priceWithReduction ,$cartItem['TVA'])?>€</p>
            </div>
            <div>
                <p>Prix HT avant remise : <?= $cartItem['prixHT']?>€</p>
                <p>Prix TTC avant remise : <?= calculedPriceWithTva($cartItem['prixHT'],$cartItem['TVA'])?>€</p>
            </div>
            
           
        <?php else :?>
            <p>Prix HT :<?= $cartItem['prixHT']?>€</p>
            <p>Prix TTC :<?= calculedPriceWithTva($cartItem['prixHT'],$cartItem['TVA'])?>€</p>
        <?php endif; ?>
    </div>
    <p class="lg:row-start-1  row-start-3 lg:col-start-6 col-start-1 flex flex-row justify-center">
        Quantités : 
        <a href="/action/removeQuantityCart.php?articlesId=<?= $cartItem['articlesId']?>" class=" px-1.5 w-8 h-8 ">
            <span class="material-symbols-outlined">remove</span>
        </a>
        <?= $cartItem['quantity']?>
        <a href="/action/addToCart.php?articlesId=<?= $cartItem['articlesId']?>">
            <span class="material-symbols-outlined">add</span>
        </a>
    </p>
    <div class="lg:col-start-7 col-start-2">
            <a href="/action/deleteFromCart.php?articlesId=<?= $cartItem['articlesId']?>">
                <span class="material-symbols-outlined">delete</span>
            </a>
    </div>
</li>