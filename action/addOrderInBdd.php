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
    clearUserCart($dbCart['cartId']);
} else {
    unset($_SESSION['cart']);
}
header("Location: /pages/validatedCart.php");
exit;