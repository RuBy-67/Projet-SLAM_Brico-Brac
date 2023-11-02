<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/php/request.php');

if (!session_id()) {
    session_start();
}

function getCartTotalQuantity(): int
{
    return array_reduce(
        $_SESSION['cart'],
        function (int $totalQuantity, array $cartItem): int {
            return $totalQuantity + $cartItem['quantity'];
        },
        0
    );
}

function getCartItemIds(): array
{
    return array_map(
        fn (array $cartItem): int => $cartItem['articleId'],
        $_SESSION['cart']
    );
}

function getCartItems(): array
{
    $sessionCartItemIds = getCartItemIds();
    $dbCartItems = getArticlesFromIds($sessionCartItemIds);
    $sessionCartItems = $_SESSION['cart'];

    return array_map(
        function (array $dbCartItem) use ($sessionCartItems) {
            $updatedCartItem = $dbCartItem;
            $updatedCartItem['quantity'] = $sessionCartItems[$dbCartItem['articlesId']]['quantity'];
            return $updatedCartItem;
        },
        $dbCartItems
    );
}