<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['ultimo_acesso'])) {
    $tempo_parado = time() - $_SESSION['ultimo_acesso'];
    if ($tempo_parado > 300) {
        session_destroy();
        header("Location: login.php?expirado=1");
        exit;
    }
}

$_SESSION['ultimo_acesso'] = time();
?>