<?php
require 'verifica.php';
// Verifica se o usuário está logado e se tem o nível de acesso de administrador
if (!isset($_SESSION["id_usuario"]) || $_SESSION["nivel_acesso"] !== "Administrador") {
    // Se não estiver logado ou não for administrador, redireciona para a página de login
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Administrador</title>
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
            margin: 20px 0;
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
        <a href="gerenciar_usuarios.php" class="menu-link">Gerenciar Usuários</a>
        <a href="gerenciar_pacientes.php" class="menu-link">Analisar Pacientes</a>
        <a href="relatorios.php" class="menu-link">Relatórios</a>
        <a href="buscar_aluno.php" class="menu-link">Buscar Aluno</a>
        <a href="anamnese.php" class="menu-link">Nova Anamnese</a>
        <a href="exibir_anamnese.php" class="menu-link">Minhas Anamneses</a>
        <!-- Adicione mais links de navegação conforme necessário -->
        <a href="logout.php" class="logout-button">Logout</a>
    </nav>

    <footer>
        <p>&copy; 2024 Unicuritiba</p>
    </footer>

</body>
</html>