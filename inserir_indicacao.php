<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Inclui o arquivo de configuração para conexão com o banco de dados
include('config.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $paciente_id = $_POST['paciente_id'];
    $mensagem = $_POST['mensagem'];
    $data_indicacao = date('Y-m-d'); // Data atual

    // Insere a indicação no banco de dados
    $query = "INSERT INTO indicacoes (paciente_id, mensagem, data_indicacao) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $paciente_id, $mensagem, $data_indicacao);

    if ($stmt->execute()) {
        echo "Indicação enviada com sucesso!";
    } else {
        echo "Erro ao enviar a indicação: " . $stmt->error;
    }

    $stmt->close();
}

// Consulta os pacientes cadastrados pelo usuário (aluno)
$usuario_id = $_SESSION['id_usuario']; // ID do aluno logado
$query_pacientes = "SELECT id, nome FROM anamnese WHERE id_usuario = ?";
$stmt = $conn->prepare($query_pacientes);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result_pacientes = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Indicação</title>
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
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        form {
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        textarea {
            resize: vertical;
        }
    </style>
</head>
<body>

    <header>
        <h1>Inserir Indicação para o Paciente</h1>
    </header>

    <div class="container">
        <h2>Formulário de Indicação</h2>
        <form method="POST" action="">
            <label for="paciente_id">Escolha o Paciente</label>
            <select id="paciente_id" name="paciente_id" required>
                <option value="">Selecione um paciente</option>
                <?php
                // Exibe os pacientes cadastrados pelo usuário
                if ($result_pacientes->num_rows > 0) {
                    while ($row = $result_pacientes->fetch_assoc()) {
                        echo "<option value='".$row['id']."'>".$row['nome']."</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum paciente cadastrado</option>";
                }
                ?>
            </select>

            <label for="mensagem">Mensagem de Indicação</label>
            <textarea id="mensagem" name="mensagem" rows="5" required placeholder="Digite a indicação para o paciente"></textarea>

            <button type="submit">Enviar Indicação</button>
        </form>

        <!-- Botão de Voltar com redirecionamento baseado no nível de acesso -->
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
