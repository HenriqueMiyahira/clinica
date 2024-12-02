<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('config.php');
session_start(); // Inicia a sessão

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botao']) && $_POST['botao'] === "Entrar") {
    // Verifica se os dados do formulário foram enviados
    var_dump($_POST);  // Depuração

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
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" required><br>

        <label>Senha:</label>
        <input type="password" name="senha" required><br>

        <input type="submit" name="botao" value="Entrar">
    </form>
</body>
</html>
