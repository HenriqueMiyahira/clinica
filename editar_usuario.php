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

// Verifica se o ID do usuário foi passado via URL
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Consulta para pegar os dados do usuário
    $query = "SELECT id_usuario, nome, email, nivel_acesso FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se o usuário for encontrado, exibe os dados
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo "Usuário não encontrado.";
        exit;
    }

    $stmt->close();
} else {
    echo "ID de usuário não fornecido.";
    exit;
}

// Se o formulário de edição for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega os novos dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $nivel_acesso = $_POST['nivel_acesso'];

    // Consulta para atualizar os dados do usuário
    $updateQuery = "UPDATE usuarios SET nome = ?, email = ?, nivel_acesso = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssi", $nome, $email, $nivel_acesso, $id_usuario);
    $stmt->execute();

    // Se a atualização for bem-sucedida, redireciona para a página de gerenciamento de usuários
    if ($stmt->affected_rows > 0) {
        header("Location: gerenciar_usuarios.php");
        exit;
    } else {
        echo "Erro ao atualizar os dados do usuário.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
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
        form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .cancel-button {
            background-color: #f44336;
        }
        .cancel-button:hover {
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
        <h1>Editar Usuário</h1>
    </header>

    <form action="editar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>

        <label for="nivel_acesso">Nível de Acesso:</label>
        <select id="nivel_acesso" name="nivel_acesso" required>
            <option value="Aluno" <?php echo $usuario['nivel_acesso'] === 'Aluno' ? 'selected' : ''; ?>>Aluno</option>
            <option value="Professor" <?php echo $usuario['nivel_acesso'] === 'Professor' ? 'selected' : ''; ?>>Professor</option>
            <option value="Administrador" <?php echo $usuario['nivel_acesso'] === 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
        </select>

        <button type="submit">Salvar Alterações</button>
        <a href="gerenciar_usuarios.php" class="cancel-button button">Cancelar</a>
    </form>

    <footer>
        <p>&copy; 2024 Sua Instituição</p>
    </footer>

</body>
</html>
