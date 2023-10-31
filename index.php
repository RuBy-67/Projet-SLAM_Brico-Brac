<?php
require './php/db.php';
 $promotion = $mysqli->query('SELECT * FROM articles WHERE nouveaute = 1');
?>
<?php require './templates/header.php'; ?>
    <!-- Slogan -->
    <section class="bg-top-banner  h-[678px] flex items-center mb-8">
        <h2 class="container w-1/2 text-white text-center">
            Bienvenue sur Brico’brac ! <br />
            La référence du magasin de bricolage près de chez vous !
        </h2>
    </section>
    <?php if ($promotion->num_rows > 0) { ?>
        <section id="promotion-product" class="splide container" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <ul class="splide__list">
                   <?php foreach ($promotion as $row) {?>
                    <li>
                        <div class="flex">
                            <h5><?= $row['nom'];?></h5>
                            <h5><?= calculedPriceWithTva($row['prixHT'],$row['TVA']);?>€ TTC</h5>
                        </div>
                </li>
                <?php } ?>
                </ul>
            </div>
        </section>
    <?php } ?>
<?php require './templates/footer.php'; ?>
