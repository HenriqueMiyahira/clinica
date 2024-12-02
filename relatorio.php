<?php
include('config.php');

require 'verifica.php';

$mysqli = new mysqli('localhost', 'root', '', 'clinica');

// Verificando se houve erro na conexão
if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}

// Consulta os dados
$sql = "SELECT id, data_avaliacao, nome FROM anamnese";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Anamnese</title>
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
        .relatorio-container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .relatorio-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .relatorio-container th,
        .relatorio-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .relatorio-container th {
            background-color: #4CAF50;
            color: white;
        }
        .btn-container {
            text-align: right;
            margin-top: 20px;
        }
        .btn-container a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin-right: 10px;
        }
        .btn-container a:hover {
            background-color: #45a049;
        }
        footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .btn-voltar {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-voltar:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
    <header>
        <h1>Relatório de Anamnese</h1>
    </header>
    <div class="relatorio-container">
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Data de Avaliação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['data_avaliacao']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum item cadastrado.</p>
        <?php endif; ?>
        <div class="btn-container">
            <a href="anamnese.php">Ir para Anamnese</a>
        </div>
        <a href="javascript:void(0);" class="btn-voltar" onclick="voltarMenu()">Voltar</a>
    </div>

    <footer>
        <p>&copy; 2024 Sua Instituição</p>
    </footer>

    <script>
        // Função para redirecionar o usuário baseado no nível de acesso
        function voltarMenu() {
            // Obtém o tipo de usuário da sessão (verifique que você está armazenando isso corretamente)
            var usuarioTipo = "<?php echo $_SESSION['nivel_acesso']; ?>";

            // Redireciona conforme o tipo de usuário
            if (usuarioTipo === 'Professor') {
                window.location.href = "menu_prof.php";
            } else if (usuarioTipo === 'Administrador') {
                window.location.href = "menu_admin.php";
            } else if (usuarioTipo === 'Aluno') {
                window.location.href = "menu_aluno.php";
            } else {
                alert("Erro: Tipo de usuário desconhecido.");
            }
        }
    </script>

</body>
</html>
