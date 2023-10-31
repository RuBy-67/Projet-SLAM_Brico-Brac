<?php
$menuItems = [
    ['name' => 'Accueil', 'url' => '../index.php'],
    ['name' => 'Produits', 'url' => '../pages/products.php'],
];
?>
<ul class="flex mr-4">
    <?php foreach ($menuItems as $item): ?>
        <li>
            <a href="<?= $item['url']; ?>" class="text-white mr-3">
            <?= $item['name']; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>