<?php
session_start();
// Incluir a configuração para o banco de dados
include('config.php');

// Verificar se o paciente está logado
if (!isset($_SESSION['paciente_id'])) {
    header("Location: login_paciente.php");
    exit();
}

$paciente_id = $_SESSION['paciente_id'];

// Buscar as indicações para o paciente
$query = "SELECT * FROM indicacoes WHERE paciente_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $paciente_id);
$stmt->execute();
$result = $stmt->get_result();

$indicações = [];
while ($row = $result->fetch_assoc()) {
    $indicações[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indicações do Paciente</title>
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
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            background-color: #f4f4f4;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            font-size: 16px;
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
        a {
            text-decoration: none;
            color: white;
            background-color: #333;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

    <header>
        <h1>Indicações para <?php echo $_SESSION['paciente_nome']; ?></h1>
    </header>

    <div class="container">
        <?php if (count($indicações) > 0): ?>
            <ul>
                <?php foreach ($indicações as $indicação): ?>
                    <li><?php echo $indicação['mensagem']; ?> <br> <small>(Data: <?php echo $indicação['data_indicacao']; ?>)</small></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Você não tem indicações ainda.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 Sua Clínica. <a href="logout.php">Sair</a></p>
    </footer>

</body>
</html>
