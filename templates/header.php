<?php
require($_SERVER['DOCUMENT_ROOT'].'/php/function.php')
?>

<header class="z-10 absolute w-full rounded-md">
    <div class="container flex lg:flex-row flex-col items-center justify-between py-4 sm:border-b sm:border-opacity-60">
        <a href="/index.php">
            <img src="/dev/assets/logo.png" alt="Brico'brac"/>
        </a>
        <div class="flex lg:flex-row flex-col items-center">
                <div class="flex items-center sm:mb-0 mb-4">
                <?php require($_SERVER['DOCUMENT_ROOT'].'/templates/menu-nav.php') ?>
                <a href="/pages/cart.php"><span class="material-symbols-outlined">shopping_cart</span></a>
            </div>
            <div class="flex sm:flex-row flex-col items-center">
                <a href="/pages/sign_in.php" class="btn sm:mr-4 sm:mb-0 mb-4">Se connnecter</a>
                <a href="/pages/sign_up.php" class="btn">Crée un compte</a>
            </div>
        </div>
        
    </div>
</header>