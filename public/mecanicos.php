<?php
include("auth.php");
include("../infra/conexao.php");

$mensagem = "";


if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $check = mysqli_query($conn, "SELECT * FROM agendamento WHERE id_mecanico = $id");
    if (mysqli_num_rows($check) > 0) {
        $mensagem = "Não é possível excluir este mecânico pois ele possui agendamentos!";
    } else {
        mysqli_query($conn, "DELETE FROM mecanico WHERE id_mecanico = $id");
        $mensagem = "Mecânico excluído com sucesso!";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_mecanico'];
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $especialidade = $_POST['especialidade'];


    $sql_mat = "SELECT * FROM mecanico WHERE matricula = '$matricula'" . ($id != "" ? " AND id_mecanico != $id" : "");
    if (mysqli_num_rows(mysqli_query($conn, $sql_mat)) > 0) {
        $mensagem = "Erro: Já existe um mecânico com essa matrícula!";
    } else {
        if ($id == "") {
            mysqli_query($conn, "INSERT INTO mecanico (nome, matricula, especialidade) VALUES ('$nome', '$matricula', '$especialidade')");
            $mensagem = "Mecânico cadastrado!";
        } else {
            mysqli_query($conn, "UPDATE mecanico SET nome='$nome', matricula='$matricula', especialidade='$especialidade' WHERE id_mecanico=$id");
            $mensagem = "Mecânico atualizado!";
        }
    }
}


$edit = ['id_mecanico' => '', 'nome' => '', 'matricula' => '', 'especialidade' => ''];
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $res = mysqli_query($conn, "SELECT * FROM mecanico WHERE id_mecanico = $id");
    $edit = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Mecânicos</title></head>
<body>
    <a href="index.php">Voltar ao Menu</a>
    <h2>Gerenciar Mecânicos</h2>
    <?php if ($mensagem != "") echo "<p style='color:blue;'>$mensagem</p>"; ?>

    <form method="POST">
        <input type="hidden" name="id_mecanico" value="<?php echo $edit['id_mecanico']; ?>">
        Nome: <input type="text" name="nome" value="<?php echo $edit['nome']; ?>" required><br><br>
        Matrícula: <input type="text" name="matricula" value="<?php echo $edit['matricula']; ?>" required><br><br>
        Especialidade: <input type="text" name="especialidade" value="<?php echo $edit['especialidade']; ?>" required><br><br>
        <button type="submit">Salvar</button>
    </form>

    <hr>
    <table border="1" cellpadding="5">
        <tr>
            <th>Nome</th><th>Matrícula</th><th>Especialidade</th><th>Ações</th>
        </tr>
        <?php
        $lista = mysqli_query($conn, "SELECT * FROM mecanico");
        while ($m = mysqli_fetch_assoc($lista)) {
            echo "<tr>
                <td>{$m['nome']}</td>
                <td>{$m['matricula']}</td>
                <td>{$m['especialidade']}</td>
                <td>
                    <a href='mecanicos.php?editar={$m['id_mecanico']}'>Editar</a> | 
                    <a href='mecanicos.php?excluir={$m['id_mecanico']}'>Excluir</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>