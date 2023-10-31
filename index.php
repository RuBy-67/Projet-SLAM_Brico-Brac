<?php
require './php/db.php';
 $promotion = $mysqli->query('SELECT * FROM articles WHERE nouveaute = 1');
?>
<?php require './templates/header.php'; ?>
    <!-- Slogan -->
    <section class="bg-top-banner  h-[678px] flex items-center mb-8">
        <h2 class="container md:w-1/2 text-white text-center lg:mt-0 md:mt-16 mt-28">
            Bienvenue sur Brico’brac ! <br />
            La référence du magasin de bricolage près de chez vous !
        </h2>
    </section>
    <?php if ($promotion->num_rows > 0) { ?>
        <section id="promotion-slider" class="splide container" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <ul class="splide__list">
                   <?php foreach ($promotion as $product) {?>
                    <li class="splide__slide">
                        <?php require './templates/card.php'; ?>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </section>
    <?php } ?>
<?php require './templates/footer.php'; ?>
