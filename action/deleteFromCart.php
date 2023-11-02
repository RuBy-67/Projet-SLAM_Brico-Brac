<?php

$articleId = $_GET['articlesId'] ?? null;
if (!$articleId) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
session_start();
unset($_SESSION['cart'][$articleId]);


header("Location: {$_SERVER['HTTP_REFERER']}");
exit;