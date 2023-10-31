<div class="card">
    <img src="" alt="" class="w-full h-[248px]">
    <div class="flex justify-between">
        <p><?= $product['nom']?></p>
        <div class="flex items-start ">
            <h6><?= calculedPriceWithTva($product['prixHT'],$product['TVA'])?>€TTC</h6>
            <span class="material-symbols-outlined">add</span>
        </div>
    </div>
</div>