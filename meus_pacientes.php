<?php
// Inicia a sessão para garantir que o usuário esteja logado
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["id_usuario"])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: login.php");
    exit;
}

// Inclui o arquivo de configuração para conexão com o banco de dados
include('config.php');

// Consulta para pegar os pacientes
$query = "SELECT id_paciente, nome, idade, diagnostico, data_cadastro FROM pacientes";
$result = $conn->query($query);

// Verifica se existem pacientes no banco
if ($result->num_rows > 0) {
    // Exibe os pacientes em uma tabela
    $pacientes = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $pacientes = [];
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pacientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <header>
        <h1>Lista de Pacientes</h1>
    </header>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Idade</th>
                <th>Diagnóstico</th>
                <th>Data de Cadastro</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($pacientes) > 0): ?>
                <?php foreach ($pacientes as $paciente): ?>
                    <tr>
                        <td><?php echo $paciente['id_paciente']; ?></td>
                        <td><?php echo $paciente['nome']; ?></td>
                        <td><?php echo $paciente['idade']; ?></td>
                        <td><?php echo $paciente['diagnostico']; ?></td>
                        <td><?php echo date("d/m/Y", strtotime($paciente['data_cadastro'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum paciente encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="menu_aluno.php" class="button">Voltar para o Menu</a>

</body>
</html>
