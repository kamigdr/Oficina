<?php
session_start();
include("../infra/conexao.php");

$erro = "";

if (isset($_GET['expirado'])) {
    $erro = "Sessão expirada, faça login novamente";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE email = '$email'";
    $res = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($res)) {
        if (password_verify($senha, $row['senha'])) {
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nome_usuario'] = $row['nome'];
            $_SESSION['ultimo_acesso'] = time();
            header("Location: index.php");
            exit;
        }
    }
    $erro = "Usuário ou senha inválidos";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - Oficina Roda Viva</title>
</head>
<body>
    <h2>Login - Oficina Roda Viva</h2>
    <?php if ($erro != "") echo "<p style='color:red;'>$erro</p>"; ?>
    
    <form method="POST">
        E-mail: <br>
        <input type="email" name="email" required><br><br>
        Senha: <br>
        <input type="password" name="senha" required><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>