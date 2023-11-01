<?php
require($_SERVER['DOCUMENT_ROOT'].'/php/function.php')
?>

<header class="z-10 absolute w-full rounded-md">
    <div class="container flex lg:flex-row flex-col items-center justify-between py-4 border-b border-opacity-60">
        <a href="/index.php">
            <img src="/dev/assets/logo.png" alt="Brico'brac"/>
        </a>
        <div class="flex items-center">
            <?php require($_SERVER['DOCUMENT_ROOT'].'/templates/menu-nav.php') ?>
            <a href="/pages/sign_in.php" class="btn">Se connnecter</a>
            <a href="/pages/sign_up.php" class="btn">Crée un compte</a>
        </div>
    </div>
</header>