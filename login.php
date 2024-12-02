<?php

include('config.php');
session_start(); // Inicia a sessão

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botao']) && $_POST['botao'] === "Entrar") {
    // Verifica se os dados do formulário foram enviados
    if (isset($_POST['nome']) && isset($_POST['senha'])) {
        // Recebe os dados do formulário
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];

        // Prepara a consulta para evitar SQL Injection
        $stmt = $conn->prepare("SELECT id_usuario, nome, senha_hash, nivel_acesso FROM usuarios WHERE nome = ?");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Verifica se o login existe
            $usuario = $result->fetch_assoc();

            // Valida a senha usando password_verify
            if (password_verify($senha, $usuario['senha_hash'])) {
                // Armazena os dados do usuário na sessão
                $_SESSION["id_usuario"] = $usuario["id_usuario"];
                $_SESSION["nome"] = $usuario["nome"];
                $_SESSION["nivel_acesso"] = $usuario["nivel_acesso"];

                // Redireciona conforme o nível de acesso
                if ($usuario['nivel_acesso'] === "Aluno") {
                    header("Location: menu_usuario.php");
                    exit; // Garante que o script seja finalizado após o redirecionamento
                } elseif ($usuario['nivel_acesso'] === "Administrador") {
                    header("Location: menu_admin.php");
                    exit; // Garante que o script seja finalizado após o redirecionamento
                } elseif ($usuario['nivel_acesso'] === "Professor") {
                    header("Location: menu_prof.php");
                    exit; // Garante que o script seja finalizado após o redirecionamento
                }
            } else {
                echo "Senha incorreta!";
            }
        } else {
            echo "Usuário não encontrado!";
        }

        $stmt->close();
    } else {
        echo "Campos não preenchidos corretamente!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .login-container {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .login-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background-color: #45a049;
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
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button-container a {
            text-decoration: none;
            padding: 10px 20px;
            margin: 5px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }
        .button-container a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <header>
        <h1>Login</h1>
    </header>

    <div class="login-container">
        <form action="login.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required placeholder="Digite seu nome">

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">

            <input type="submit" name="botao" value="Entrar">
        </form>
    </div>

    <div class="button-container">
        <a href="cadastro.php">Cadastrar Novo Usuário</a> <!-- Redireciona para a página de cadastro -->
        <a href="login_paciente.php">Entrar como Paciente</a> <!-- Redireciona para a página de login do paciente -->
    </div>

    <footer>
        <p>&copy; 2024 Sistema de Login</p>
    </footer>

</body>
</html>
