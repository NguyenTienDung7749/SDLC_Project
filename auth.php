<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_login() {
    return isset($_SESSION["user_id"]);
}

function require_login() {
    if (!is_login()) {
        header("Location: login.php");
        exit;
    }
}

function require_admin() {
    require_login();
    if ($_SESSION["role"] !== "admin") {
        header("Location: index.php");
        exit;
    }
}
?>