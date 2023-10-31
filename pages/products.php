<?php
require '../php/db.php';
 $products = $mysqli->query('SELECT * FROM articles');
?>
<?php require '../templates/header.php'; ?>
    <!-- Slogan -->
    <section class="bg-top-banner  h-[400px] flex items-center mb-16">
        <h2 class="container w-1/2 text-white text-center mt-20">Nos Produits</h2>
    </section>
    <?php if ($products->num_rows > 0) { ?>
        <section class="container grid gap-8 lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 mb-16">
            <?php foreach ($products as $product): ?>
                <?php require '../templates/card.php'; ?>
            <?php endforeach; ?>
        </section>
    <?php } ?>
<?php require '../templates/footer.php'; ?>
