<?php

$articleId = $_GET['articlesId'] ?? null;
if (!$articleId) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/Projet-SLAM_Brico-Brac/php/authentication.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Projet-SLAM_Brico-Brac/php/cart.php');

if (isUserLoggedIn()) {
    $dbCart = getFullCartByUser(getUserId());
    removeCartItemFromCart($articleId, $dbCart['cartId']);
} else {
    unset($_SESSION['cart'][$articleId]);
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }
}

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;