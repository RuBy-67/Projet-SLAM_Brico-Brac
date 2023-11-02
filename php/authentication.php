<?php

if (!session_id()) {
    session_start();
}

function isUserLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

function getUserId(): int
{
    return $_SESSION['id'];
}