<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/php/request.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication.php');

if (!session_id()) {
    session_start();
}

function getCartTotalQuantity(): int
{
    $items = isUserLoggedIn() ? getFullCartByUser(getUserId())['items'] : $_SESSION['cart'];

    return array_reduce(
        $items,
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
    $cartItems = [];

    if (isCartEmpty()) {
        return $cartItems;
    }

    if (isUserLoggedIn()) {
        return getFullCartByUser(getUserId())['items'];
    } else {
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
}

function isCartEmpty(): bool
{
    if (isUserLoggedIn()) {
        return empty(getFullCartByUser(getUserId())['items']);
    }

    return !isset($_SESSION['cart']) || empty($_SESSION['cart']);
}

function getCartByUser(int $userId): array
{
    $cart = getCart($userId);

    if ($cart === null) {
        createCart($userId);
        $cart = getCart($userId);
    }
    
    return $cart;
}

function getCartItemsByCart(int $cartId): array
{
    return getCartItemsFromCart($cartId);
}

function getFullCartByUser(int $userId): array
{
    $cart = getCartByUser($userId);
    $cart['items'] = getCartItemsByCart($cart['cartId']);

    return $cart;
}

function doesArticleExistInCart(int $articleId, array $cart): bool
{
    $items = $cart['items'];
    foreach ($items as $item) {
        if ($item['articleId'] == $articleId) {
            return true;
        }
    }

    return false;
}

function updateQuantityOfArticle(int $cartId, int $articleId, int $newQuantity): void
{
    updateCartItemQuantity($cartId, $articleId, $newQuantity);
}

function addCartItemToCart(int $cartId, int $articleId): void
{
    createCartItem($cartId, $articleId);
}

function getCartItemQuantity(int $articleId, array $cart): int
{
    foreach ($cart['items'] as $cartItem) {
        if ($cartItem['articleId'] == $articleId) {
            return $cartItem['quantity'];
        }
    }

    return 0;
}

function doesCartExist(): bool
{
    if (isUserLoggedIn()) {
        return !empty(getFullCartByUser(getUserId())['items']);
    }

    return isset($_SESSION['cart']);
}

function removeCartItemFromCart(int $articleId, int $cartId): void
{
    deleteCartItem($articleId, $cartId);
}

function clearUserCart(int $cartId,):void{

    deleteAllItemsOfCart($cartId);
    deleteCart($cartId);
}

    
