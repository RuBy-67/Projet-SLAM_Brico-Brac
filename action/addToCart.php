<?php

$articleId = $_GET['articlesId'] ?? null;
if (!$articleId) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

session_start();

if ($_SESSION['cart'][$articleId] !== null) {
    $_SESSION['cart'][$articleId]['quantity'] += 1;
} else {
    $_SESSION['cart'][$articleId] = [
        'articleId' => $articleId,
        'quantity' => 1
    ];
}


header("Location: {$_SERVER['HTTP_REFERER']}");
exit;