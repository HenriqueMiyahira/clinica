<?php
// Inicia a sessão para garantir que o usuário esteja logado
session_start();

// Verifica se o usuário está logado e se tem o nível de acesso de administrador
if (!isset($_SESSION["id_usuario"]) || $_SESSION["nivel_acesso"] !== "Administrador") {
    // Se não estiver logado ou não for administrador, redireciona para a página de login
    header("Location: login.php");
    exit;
}

// Inclui o arquivo de configuração para conexão com o banco de dados
include('config.php');

// Consulta para pegar todos os usuários
$query = "SELECT id_usuario, nome, email, nivel_acesso, data_criacao FROM usuarios";
$result = $conn->query($query);

// Verifica se existem usuários no banco
if ($result->num_rows > 0) {
    // Exibe os usuários em uma tabela
    $usuarios = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $usuarios = [];
}

// Se um formulário de edição ou exclusão for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['excluir'])) {
        // Excluir usuário
        $id_usuario = $_POST['id_usuario'];
        $deleteQuery = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->close();
        header("Location: gerenciar_usuarios.php");
        exit;
    } elseif (isset($_POST['editar'])) {
        // Redirecionar para a página de edição
        $id_usuario = $_POST['id_usuario'];
        header("Location: editar_usuario.php?id=$id_usuario");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
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
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .button:hover {
            background-color: #45a049;
        }
        .delete-button {
            background-color: #f44336;
        }
        .delete-button:hover {
            background-color: #e53935;
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
    </style>
</head>
<body>

    <header>
        <h1>Gerenciar Usuários</h1>
    </header>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Nível de Acesso</th>
                <th>Data de Criação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($usuarios) > 0): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id_usuario']; ?></td>
                        <td><?php echo $usuario['nome']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td><?php echo $usuario['nivel_acesso']; ?></td>
                        <td><?php echo date("d/m/Y", strtotime($usuario['data_criacao'])); ?></td>
                        <td>
                            <form action="gerenciar_usuarios.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                                <button type="submit" name="editar" class="button">Editar</button>
                                <button type="submit" name="excluir" class="button delete-button">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhum usuário encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="menu_admin.php" class="button">Voltar para o Menu</a>

    <footer>
        <p>&copy; 2024 Sua Instituição</p>
    </footer>

</body>
</html>
