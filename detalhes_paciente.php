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

// Verifica se o ID do paciente foi passado pela URL
if (isset($_GET['id'])) {
    $id_paciente = $_GET['id'];

    // Consulta para pegar os detalhes do paciente
    $query = "SELECT * FROM anamnese WHERE nome = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_paciente);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o paciente foi encontrado
    if ($result->num_rows > 0) {
        $paciente = $result->fetch_assoc();
    } else {
        echo "Paciente não encontrado.";
        exit;
    }

    $stmt->close();
} else {
    echo "ID de paciente não fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Paciente</title>
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
        .btn-voltar, .btn-anamnese {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-voltar:hover, .btn-anamnese:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <header>
        <h1>Detalhes do Paciente</h1>
    </header>

    <div class="container">
        <h2>Informações do Paciente</h2>
        <table>
            <tr>
                <th>Nome</th>
                <td><?php echo $paciente['nome']; ?></td>
            </tr>
            <tr>
                <th>Altura</th>
                <td><?php echo $paciente['altura']; ?></td>
            </tr>
            <tr>
                <th>Endereço</th>
                <td><?php echo $paciente['endereco']; ?></td>
            </tr>
            <tr>
                <th>Telefone</th>
                <td><?php echo $paciente['telefone']; ?></td>
            </tr>
            <tr>
                <th>Data de Nascimento</th>
                <td><?php echo date("d/m/Y", strtotime($paciente['data_nascimento'])); ?></td>
            </tr>
            <tr>
                <th>Idade</th>
                <td><?php echo $paciente['idade']; ?></td>
            </tr>
            <tr>
                <th>Gênero</th>
                <td><?php echo $paciente['genero']; ?></td>
            </tr>
            <!-- Adicione outros campos conforme necessário -->
        </table>

        <!-- Botão para redirecionar para a página de anamnese -->
        <a href="gerenciar_pacientes.php" class="btn-voltar">Voltar para a Lista de Pacientes</a>
        <a href="ver_anamnese.php?id=<?php echo $paciente['nome']; ?>" class="btn-anamnese">Ver Anamnese</a>
        
       
    </div>

    <footer>
        <p>&copy; 2024 Sua Instituição</p>
    </footer>

</body>
</html>
