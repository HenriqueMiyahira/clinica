<?php
// Inicia a sessão para garantir que o usuário esteja logado
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["id_usuario"])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: login.php");
    exit;
}

// Inclui o arquivo de configuração do banco de dados
include('config.php');

// Verifica se o ID do usuário foi passado como parâmetro
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID do usuário não fornecido.";
    exit;
}

$id_usuario = $_GET['id'];

// Consulta para obter os detalhes do usuário
$queryUsuario = "SELECT id_usuario, nome, email, nivel_acesso FROM usuarios WHERE id_usuario = ?";
$stmtUsuario = $conn->prepare($queryUsuario);
$stmtUsuario->bind_param("i", $id_usuario);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();

if ($resultUsuario->num_rows === 0) {
    echo "Usuário não encontrado.";
    exit;
}

$usuario = $resultUsuario->fetch_assoc();

// Consulta para buscar as anamneses associadas ao usuário
$queryAnamneses = "SELECT id, data_avaliacao, nome FROM anamnese WHERE id_usuario = ? ORDER BY data_avaliacao DESC";
$stmtAnamneses = $conn->prepare($queryAnamneses);
$stmtAnamneses->bind_param("i", $id_usuario);
$stmtAnamneses->execute();
$resultAnamneses = $stmtAnamneses->get_result();

$stmtUsuario->close();
$stmtAnamneses->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Usuário</title>
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
        .details-container {
            margin: 20px auto;
            width: 80%;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .details-container h2 {
            margin-top: 0;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #4CAF50;
            color: white;
        }
        .back-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            width: 200px;
        }
        .back-button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

    <header>
        <h1>Detalhes do Usuário</h1>
    </header>

    <div class="details-container">
        <h2>Informações do Usuário</h2>
        <p><strong>ID:</strong> <?php echo $usuario['id_usuario']; ?></p>
        <p><strong>Nome:</strong> <?php echo $usuario['nome']; ?></p>
        <p><strong>Email:</strong> <?php echo $usuario['email']; ?></p>
        <p><strong>Nível de Acesso:</strong> <?php echo ucfirst($usuario['nivel_acesso']); ?></p>

        <div class="table-container">
            <h2>Anamneses do Usuário</h2>
            <?php if ($resultAnamneses->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($anamnese = $resultAnamneses->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo date("d/m/Y", strtotime($anamnese['data_avaliacao'])); ?></td>
                                <td><?php echo substr($anamnese['nome'], 0, 100); ?>...</td>
                                <td><a href="detalhes_anamnese.php?id=<?php echo $anamnese['id']; ?>">Ver Detalhes</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Este usuário não possui anamneses registradas.</p>
            <?php endif; ?>
        </div>
    </div>

    <a href="buscar_aluno.php" class="back-button">Voltar</a>

</body>
</html>
