<?php if (!session_id()) {
    session_start();
}
header('Location: ../index.php');
    exit();

?>