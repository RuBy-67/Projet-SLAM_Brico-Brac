<?php

session_start();

unset($_SESSION['cart']);

header("Location: /pages/validatedCart.php");
exit;