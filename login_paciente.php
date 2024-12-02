<?php
session_start();
// Incluir o arquivo de configuração para conexão com o banco de dados
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];

    // Consulta para verificar se o paciente existe na tabela 'anamnese'
    $query = "SELECT * FROM anamnese WHERE nome = ? AND data_nascimento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $nome, $data_nascimento);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Paciente encontrado, iniciar sessão
        $paciente = $result->fetch_assoc();
        $_SESSION['paciente_id'] = $paciente['id'];
        $_SESSION['paciente_nome'] = $paciente['nome'];
        $_SESSION['paciente_data_nascimento'] = $paciente['data_nascimento'];
        
        // Redireciona o paciente para a página de indicações
        header("Location: indicacoes.php");
        exit();
    } else {
        $erro = "Nome ou data de nascimento inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Paciente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
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
        <h1>Login do Paciente</h1>
    </header>

    <div class="container">
        <!-- Exibir mensagem de erro caso o login falhe -->
        <?php if (isset($erro)) { echo "<p class='error-message'>$erro</p>"; } ?>

        <!-- Formulário de Login -->
        <form method="POST" action="login_paciente.php">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required><br><br>

            <button type="submit">Login</button>
        </form>
