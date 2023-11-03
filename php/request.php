<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/php/db.php');

function getArticlesFromIds(array $ids): array
{
    global $mysqli;
    $idsCommaSeparatedString = implode(',', $ids);
    return $mysqli->query("SELECT * FROM articles WHERE articlesId IN ({$idsCommaSeparatedString})")
                  ->fetch_all(MYSQLI_ASSOC);
}

require_once($_SERVER['DOCUMENT_ROOT'].'/php/db.php');

function getArticleInfos(string $id):array
{
    global $mysqli;
    return $mysqli->query("SELECT * FROM articles WHERE articlesId IN ({$id})")
                  ->fetch_all(MYSQLI_ASSOC);
}

function getNewArticles()
{
    global $mysqli;
    return $mysqli->query('SELECT * FROM articles WHERE nouveaute = 1');
}

function getArticlesWithPromotion()
{
    global $mysqli;
    return $mysqli->query('SELECT * FROM articles WHERE pourcentagePromotion IS NOT NULL');
}

function getCart(int $userId): ?array
{
    global $mysqli;
    $cart = $mysqli->query("SELECT * FROM cart WHERE userId = {$userId}")
                  ->fetch_all(MYSQLI_ASSOC);

    if (empty($cart) || !isset($cart[0])) {
        return null;
    }

    return $cart[0];
}

function createCart(int $userId): void
{
    global $mysqli;
    $mysqli->query("INSERT INTO cart (userId) VALUES ({$userId})");
}

function getCartItemsFromCart(int $cartId): array
{
    global $mysqli;
    return $mysqli->query("SELECT cartitems.*, articles.* FROM cartitems JOIN articles ON cartItems.articleId = articles.articlesId WHERE cartItems.cartId = {$cartId}")
                  ->fetch_all(MYSQLI_ASSOC);
}

function updateCartItemQuantity(int $cartId, int $articleId, int $newQuantity): void
{
    global $mysqli;
    $mysqli->query("UPDATE cartitems SET quantity = {$newQuantity} WHERE cartId = {$cartId} AND articleId = {$articleId}");
}

function createCartItem(int $cartId, int $articleId): void
{
    global $mysqli;
    $mysqli->query("INSERT INTO cartitems (articleId, quantity, cartId) VALUES ({$articleId}, 1, {$cartId})");
}

function deleteCartItem(int $articleId, int $cartId): void
{
    global $mysqli;
    $mysqli->query("DELETE FROM cartitems WHERE articleId = {$articleId} AND cartId = {$cartId}");
}