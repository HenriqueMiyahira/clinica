<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado e é um administrador
if (!isset($_SESSION["id_usuario"]) || $_SESSION["nivel_acesso"] !== 'Administrador') {
    header("Location: login.php");
    exit;
}

// Inclui o arquivo de configuração para conexão com o banco de dados
include('config.php');

// Consulta para exibir todos os pacientes
$query = "SELECT * FROM anamnese";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se há pacientes cadastrados
$pacientes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pacientes[] = $row;
    }
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pacientes</title>
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
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        .container {
            text-align: center;
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
        .btn-detalhes {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-detalhes:hover {
            background-color: #45a049;
        }
         
        .btn-voltar, .btn-anamnese {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Gerenciamento de Pacientes</h1>
    </header>

    <div class="container">
        <h2>Lista de Pacientes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Data Nascimento</th>
                    <th>Idade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pacientes)): ?>
                    <?php foreach ($pacientes as $paciente): ?>
                        <tr>
                            <td><?php echo $paciente['nome']; ?></td>
                            <td><?php echo $paciente['altura']; ?></td>
                            <td><?php echo $paciente['endereco']; ?></td>
                            <td><?php echo $paciente['telefone']; ?></td>
                            <td><?php echo date("d/m/Y", strtotime($paciente['data_nascimento'])); ?></td>
                            <td><?php echo $paciente['idade']; ?></td>
                            <td>
                                <a href="detalhes_paciente.php?id=<?php echo $paciente['nome']; ?>" class="btn-detalhes">Ver Detalhes</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Nenhum paciente encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <a href="javascript:void(0);" class="btn-voltar" onclick="voltarMenu()">Voltar</a>
    <a href="inserir_indicacao.php" class="btn-voltar">Inserir Indicações para o Paciente</a>
    
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
                window.location.href = "menu_usuario.php";
            } else {
                alert("Erro: Tipo de usuário desconhecido.");
            }
        }
    </script>

</body>
</html>
