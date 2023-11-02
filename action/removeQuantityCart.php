<?php

$articleId = $_GET['articlesId'] ?? null;
if (!$articleId) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

session_start();
if( $_SESSION['cart'][$articleId]['quantity'] == 1 ){
    unset($_SESSION['cart'][$articleId]);
}else{
    $_SESSION['cart'][$articleId]['quantity'] -= 1;
}

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;