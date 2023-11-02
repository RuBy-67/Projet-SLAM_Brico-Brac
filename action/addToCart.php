<?php

$articleId = $_GET['articlesId'] ?? null;
if (!$articleId) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/cart.php');

if (isUserLoggedIn()) {
    $dbCart = getFullCartByUser(getUserId());
    if (doesArticleExistInCart($articleId, $dbCart)) {
        $newQuantity = getCartItemQuantity($articleId, $dbCart) + 1;
        updateQuantityOfArticle($dbCart['cartId'], $articleId, $newQuantity);
    } else {
        addCartItemToCart($dbCart['cartId'], $articleId);
    }
} else {
    if ($_SESSION['cart'][$articleId] !== null) {
        $_SESSION['cart'][$articleId]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$articleId] = [
            'articleId' => $articleId,
            'quantity' => 1
        ];
    }
}

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;