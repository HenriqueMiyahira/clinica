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

// Pega o ID do usuário logado
$id_usuario = $_SESSION["id_usuario"];

// Consulta para buscar todas as anamneses associadas ao usuário logado
$query = "SELECT a.id, a.data_avaliacao, a.nome FROM anamnese a WHERE a.id_usuario = ? ORDER BY a.nome DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se há anamneses
if ($result->num_rows > 0) {
    // Exibe as anamneses
    $anamneses = [];
    while ($row = $result->fetch_assoc()) {
        $anamneses[] = $row;
    }
} else {
    $anamneses = null; // Caso não haja anamnese
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anamnese</title>
    <style>
        /* Defina uma altura mínima para o body e permita o overflow vertical */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            min-height: 100vh;  /* Garantir que o body ocupe toda a altura da tela */
            overflow-y: auto;  /* Permite rolagem vertical quando necessário */
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

        .btn-voltar {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-voltar:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <header>
        <h1>Anamnese - Histórico de Consultas</h1>
    </header>

    <div class="container">
        <h2>Suas Anamneses</h2>
        
        <?php if ($anamneses !== null): ?>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anamneses as $anamnese): ?>
                        <tr>
                            <td><?php echo date("d/m/Y", strtotime($anamnese['data_avaliacao'])); ?></td>
                            <td><?php echo substr($anamnese['nome'], 0, 100); ?></td>
                            <td><a href="detalhes_anamnese.php?id=<?php echo $anamnese['id']; ?>">Ver detalhes</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Você ainda não tem anamneses registradas.</p>
        <?php endif; ?>
    </div>

    <!-- Botão para voltar -->
    <a href="javascript:void(0);" class="btn-voltar" onclick="voltarMenu()">Voltar</a>
    <a href="inserir_indicacao.php" class="btn-voltar">Inserir Indicações para o Paciente</a>

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
