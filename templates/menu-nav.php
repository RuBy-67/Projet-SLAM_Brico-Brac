<?php
$menuItems = [
    ['name' => 'Accueil', 'url' => '../index.php'],
    ['name' => 'Produits', 'url' => '../pages/products.php'],
];
?>
<ul class="flex lg:mr-4">
    <?php foreach ($menuItems as $item): ?>
        <li>
            <a href="<?= $item['url']; ?>" class="text-white mx-1.5">
            <?= $item['name']; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>