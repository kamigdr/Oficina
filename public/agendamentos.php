<?php
include("auth.php");
include("../infra/conexao.php");

$mensagem = "";


if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    mysqli_query($conn, "DELETE FROM agendamento WHERE id_agendamento = $id");
    $mensagem = "Agendamento excluído!";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_agendamento'];
    $id_cliente = $_POST['id_cliente'];
    $id_mecanico = $_POST['id_mecanico'];
    $placa = $_POST['placa'];
    $data_hora = $_POST['data_hora'];


    $sql_check = "SELECT * FROM agendamento WHERE id_mecanico = $id_mecanico AND data_hora = '$data_hora'" . ($id != "" ? " AND id_agendamento != $id" : "");
    
    if (mysqli_num_rows(mysqli_query($conn, $sql_check)) > 0) {
        $mensagem = "Aviso: Este mecânico já possui um agendamento nesta data e horário!";
    } else {
        if ($id == "") {
            mysqli_query($conn, "INSERT INTO agendamento (id_cliente, id_mecanico, data_hora, placa) VALUES ($id_cliente, $id_mecanico, '$data_hora', '$placa')");
            $mensagem = "Agendamento realizado!";
        } else {
            mysqli_query($conn, "UPDATE agendamento SET id_cliente=$id_cliente, id_mecanico=$id_mecanico, data_hora='$data_hora', placa='$placa' WHERE id_agendamento=$id");
            $mensagem = "Agendamento atualizado!";
        }
    }
}


$edit = ['id_agendamento' => '', 'id_cliente' => '', 'id_mecanico' => '', 'data_hora' => '', 'placa' => ''];
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $res = mysqli_query($conn, "SELECT * FROM agendamento WHERE id_agendamento = $id");
    $edit = mysqli_fetch_assoc($res);

    $edit['data_hora'] = date('Y-m-d\TH:i', strtotime($edit['data_hora']));
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Agendamentos</title></head>
<body>
    <a href="index.php">Voltar ao Menu</a>
    <h2>Gerenciar Agendamentos</h2>
    <?php if ($mensagem != "") echo "<p style='color:red;'>$mensagem</p>"; ?>

    <form method="POST">
        <input type="hidden" name="id_agendamento" value="<?php echo $edit['id_agendamento']; ?>">
        
        Cliente: 
        <select name="id_cliente" required>
            <option value="">Selecione...</option>
            <?php
            $clientes = mysqli_query($conn, "SELECT * FROM cliente");
            while ($c = mysqli_fetch_assoc($clientes)) {
                $sel = ($c['id_cliente'] == $edit['id_cliente']) ? "selected" : "";
                echo "<option value='{$c['id_cliente']}' $sel>{$c['nome']}</option>";
            }
            ?>
        </select><br><br>

        Mecânico: 
        <select name="id_mecanico" required>
            <option value="">Selecione...</option>
            <?php
            $mecanicos = mysqli_query($conn, "SELECT * FROM mecanico");
            while ($m = mysqli_fetch_assoc($mecanicos)) {
                $sel = ($m['id_mecanico'] == $edit['id_mecanico']) ? "selected" : "";
                echo "<option value='{$m['id_mecanico']}' $sel>{$m['nome']} ({$m['especialidade']})</option>";
            }
            ?>
        </select><br><br>

        Placa do Veículo: 
        <input type="text" name="placa" maxlength="8" value="<?php echo $edit['placa']; ?>" required><br><br>

        Data e Hora: 
        <input type="datetime-local" name="data_hora" value="<?php echo $edit['data_hora']; ?>" required><br><br>

        <button type="submit">Salvar Agendamento</button>
    </form>

    <hr>
    <table border="1" cellpadding="5">
        <tr>
            <th>Cliente</th>
            <th>Placa</th>
            <th>Mecânico</th>
            <th>Especialidade</th>
            <th>Data/Hora</th>
            <th>Ações</th>
        </tr>
        <?php
        $sql_lista = "SELECT a.*, c.nome AS cliente_nome, m.nome AS mecanico_nome, m.especialidade 
                      FROM agendamento a
                      JOIN cliente c ON a.id_cliente = c.id_cliente
                      JOIN mecanico m ON a.id_mecanico = m.id_mecanico
                      ORDER BY a.data_hora ASC";
        $lista = mysqli_query($conn, $sql_lista);
        
        while ($a = mysqli_fetch_assoc($lista)) {
            $data_formatada = date('d/m/Y H:i', strtotime($a['data_hora']));
            echo "<tr>
                <td>{$a['cliente_nome']}</td>
                <td>{$a['placa']}</td>
                <td>{$a['mecanico_nome']}</td>
                <td>{$a['especialidade']}</td>
                <td>{$data_formatada}</td>
                <td>
                    <a href='agendamentos.php?editar={$a['id_agendamento']}'>Editar</a> | 
                    <a href='agendamentos.php?excluir={$a['id_agendamento']}'>Excluir</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>