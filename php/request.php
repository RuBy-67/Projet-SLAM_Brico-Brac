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