<?php
    session_start();
    unset($_SESSION["employeer_name"]);
    unset($_SESSION["employeer_number"]);
    unset($_SESSION["employeer_id"]);
    unset($_SESSION["userip"]);
    setcookie("employeer_name", "");
    setcookie("employeer_passwd", "");
    header("Location: ../index.php");
?>