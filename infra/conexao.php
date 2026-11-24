<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "oficina_viva";
$porta = 3306;

$conn = mysqli_connect($host, $usuario, $senha, $banco, $porta);

if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>