<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/php/db.php');

function getArticlesFromIds(array $ids): array
{
    global $mysqli;
    $idsCommaSeparatedString = implode(',', $ids);
    return $mysqli->query("SELECT * FROM articles WHERE articlesId IN ({$idsCommaSeparatedString})")
                  ->fetch_all(MYSQLI_ASSOC);
}