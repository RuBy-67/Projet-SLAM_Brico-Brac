<?php
$menuItems = [
    ['name' => 'Accueil', 'url' => '/Projet-SLAM_Brico-Brac/index.php'],
    ['name' => 'Produits', 'url' => '/Projet-SLAM_Brico-Brac/pages/products.php'],
];
?>
<ul class="flex mr-4">
    <?php foreach ($menuItems as $item): ?>
        <li>
            <a href="<?= $item['url']; ?>" class="text-white mx-1.5">
            <?= $item['name']; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>