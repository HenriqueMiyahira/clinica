<?php
// Inicia a sessão para garantir que o usuário esteja logado
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["id_usuario"])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Aluno</title>
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
        nav {
            margin: 20px;
        }
        .menu-link {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: #ddd;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
            width: 200px;
            text-align: center;
        }
        .menu-link:hover {
            background-color: #ccc;
        }
        .logout-button {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: #f44336;
            color: white;
            border-radius: 5px;
            width: 200px;
            text-align: center;
            text-decoration: none;
        }
        .logout-button:hover {
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
        <h1>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h1>
        <p>Escolha uma das opções abaixo:</p>
    </header>

    <nav>
        <a href="anamnese.php" class="menu-link">Ir para Anamnese</a>
        <!-- Adicione outros links de navegação aqui conforme necessário -->
        <a href="logout.php" class="logout-button">Logout</a> <!-- Botão de logout -->
    </nav>

    <footer>
        <p>&copy; 2024 Sua Instituição</p>
    </footer>

</body>
</html>
