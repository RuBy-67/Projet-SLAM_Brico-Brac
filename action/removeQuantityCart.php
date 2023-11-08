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
    $newQuantity = getCartItemQuantity($articleId, $dbCart) - 1;
    if ($newQuantity === 0) {
        removeCartItemFromCart($articleId, $dbCart['cartId']);
    } else {
        updateQuantityOfArticle($dbCart['cartId'], $articleId, $newQuantity);
    }
} else {
    if( $_SESSION['cart'][$articleId]['quantity'] == 1 ){
        unset($_SESSION['cart'][$articleId]);
    }else{
        $_SESSION['cart'][$articleId]['quantity'] -= 1;
    }
}

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;