<?php
$usergroup = $_SESSION['group'];
require_once($_SERVER['DOCUMENT_ROOT'].'/php/cart.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/function.php');
?>

<header class="z-10 absolute w-full rounded-md">
    <div class="container flex lg:flex-row flex-col items-center justify-between py-4 sm:border-b sm:border-opacity-60">
        <a href="/index.php">
            <img src="/dev/assets/logo.png" alt="Brico'brac"/>
        </a>
        <div class="flex lg:flex-row flex-col items-center">
                <div class="flex items-center sm:mb-0 mb-4">
                <?php require($_SERVER['DOCUMENT_ROOT'].'/templates/menu_nav.php') ?>
                <a href="/pages/cart.php" class="lg:mr-4 relative">
                    <span class="material-symbols-outlined text-white">shopping_cart</span>
                    <?php if (isset($_SESSION['cart'])) : ?>
                        <span class="text-primary text-xs border border-primary font-bold absolute -top-2.5 -right-2.5 bg-white rounded-full w-5 h-5 text-center leading-5">
                            <?= getCartTotalQuantity() ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
            <div class="flex sm:flex-row flex-col items-center">
                <?php
                if (isset($_SESSION['username'])) {
                    // Utilisateur connecté
                    echo '<div class="flex sm:flex-row flex-col items-center">';
                    echo '<span class="mr-4 mb-4">' . $_SESSION['username'] . '</span>';
                    if ($_SESSION['group'] === 1 || $_SESSION['group'] === 2) {
                        // Utilisateur connecté et a un groupe de 1 (Vendeur) ou 2 (Admin)
                        echo '<a href="/pages/sign_in.php" class="btn">Gestion</a>';
                    }
                    echo '</div>';
                } else {
                    // Utilisateur non connecté
                    echo '<div class="flex sm:flex-row flex-col items-center">';
                    echo '<a href="/pages/sign_in.php" class="btn mr-4 mb-4">Se connecter</a>';
                    echo '<a href="/pages/sign_up.php" class="btn">Créer un compte</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        
    </div>
</header>