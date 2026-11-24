<?php include("auth.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Menu Principal</title>
</head>
<body>
    <h2>Oficina Roda Viva</h2>
    <p>Bem-vindo(a), <strong><?php echo $_SESSION['nome_usuario']; ?></strong>!</p>
    
    <ul>
        <li><a href="clientes.php">Clientes</a></li>
        <li><a href="mecanicos.php">Mecânicos</a></li>
        <li><a href="agendamentos.php">Agendamentos</a></li>
        <li><a href="logout.php">Sair</a></li>
    </ul>
</body>
</html>