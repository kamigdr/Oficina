<?php
include("auth.php");
include("../infra/conexao.php");

$mensagem = "";


if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    $check = mysqli_query($conn, "SELECT * FROM agendamento WHERE id_cliente = $id");
    if (mysqli_num_rows($check) > 0) {
        $mensagem = "Não é possível excluir este cliente pois ele possui agendamentos!";
    } else {
        mysqli_query($conn, "DELETE FROM cliente WHERE id_cliente = $id");
        $mensagem = "Cliente excluído com sucesso!";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_cliente'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    if ($id == "") {
        mysqli_query($conn, "INSERT INTO cliente (nome, telefone, email) VALUES ('$nome', '$telefone', '$email')");
        $mensagem = "Cliente cadastrado!";
    } else {
        mysqli_query($conn, "UPDATE cliente SET nome='$nome', telefone='$telefone', email='$email' WHERE id_cliente=$id");
        $mensagem = "Cliente atualizado!";
    }
}


$edit = ['id_cliente' => '', 'nome' => '', 'telefone' => '', 'email' => ''];
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $res = mysqli_query($conn, "SELECT * FROM cliente WHERE id_cliente = $id");
    $edit = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Clientes</title></head>
<body>
    <a href="index.php">Voltar ao Menu</a>
    <h2>Gerenciar Clientes</h2>
    <?php if ($mensagem != "") echo "<p style='color:blue;'>$mensagem</p>"; ?>

    <form method="POST">
        <input type="hidden" name="id_cliente" value="<?php echo $edit['id_cliente']; ?>">
        Nome: <input type="text" name="nome" value="<?php echo $edit['nome']; ?>" required><br><br>
        Telefone: <input type="text" name="telefone" value="<?php echo $edit['telefone']; ?>" required><br><br>
        E-mail: <input type="email" name="email" value="<?php echo $edit['email']; ?>" required><br><br>
        <button type="submit">Salvar</button>
    </form>

    <hr>
    <table border="1" cellpadding="5">
        <tr>
            <th>Nome</th><th>Telefone</th><th>E-mail</th><th>Ações</th>
        </tr>
        <?php
        $lista = mysqli_query($conn, "SELECT * FROM cliente");
        while ($c = mysqli_fetch_assoc($lista)) {
            echo "<tr>
                <td>{$c['nome']}</td>
                <td>{$c['telefone']}</td>
                <td>{$c['email']}</td>
                <td>
                    <a href='clientes.php?editar={$c['id_cliente']}'>Editar</a> | 
                    <a href='clientes.php?excluir={$c['id_cliente']}'>Excluir</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>