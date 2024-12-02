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

// Inicializa a variável de resultado da busca
$resultadoBusca = null;

// Verifica se o formulário de busca foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buscar'])) {
    $termoBusca = trim($_POST['termo_busca']);
    
    // Valida o termo de busca
    if (!empty($termoBusca)) {
        $query = "SELECT id_usuario, nome, email, nivel_acesso FROM usuarios 
                  WHERE nivel_acesso = 'aluno' 
                  AND (nome LIKE ? OR email LIKE ?)";
        $stmt = $conn->prepare($query);
        $likeTerm = '%' . $termoBusca . '%';
        $stmt->bind_param('ss', $likeTerm, $likeTerm);
        $stmt->execute();
        $resultadoBusca = $stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuário</title>
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
        .search-form {
            margin: 20px auto;
            text-align: center;
        }
        .search-input {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .search-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-button:hover {
            background-color: #45a049;
        }
        .results-table {
            margin: 20px auto;
            width: 80%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .results-table th, .results-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .results-table th {
            background-color: #4CAF50;
            color: white;
        }
        .menu-button {
            display: block;
            margin: 10px auto;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            width: 200px;
        }
        .menu-button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

    <header>
        <h1>Buscar Usuário (Aluno)</h1>
    </header>

    <div class="search-form">
        <form method="POST">
            <input type="text" name="termo_busca" class="search-input" placeholder="Buscar usuário por nome ou email">
            <button type="submit" name="buscar" class="search-button">Buscar</button>
        </form>
    </div>

    <?php if ($resultadoBusca && $resultadoBusca->num_rows > 0): ?>
        <table class="results-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Nível de Acesso</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $resultadoBusca->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $usuario['id_usuario']; ?></td>
                        <td><?php echo $usuario['nome']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td><?php echo ucfirst($usuario['nivel_acesso']); ?></td>
                        <td>
                            <a href="detalhes_aluno.php?id=<?php echo $usuario['id_usuario']; ?>" class="search-button" style="text-decoration: none; display: inline-block; padding: 5px 10px;">Ver Detalhes</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php elseif ($resultadoBusca): ?>
        <p style="text-align: center; color: red;">Nenhum usuário encontrado.</p>
    <?php endif; ?>

    <a href="menu_usuario.php" class="menu-button">Voltar ao Menu</a>

</body>
</html>
