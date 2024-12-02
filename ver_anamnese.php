<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado e é um administrador
if (!isset($_SESSION["id_usuario"]) || $_SESSION["nivel_acesso"] !== 'Administrador') {
    header("Location: login.php");
    exit;
}

// Inclui o arquivo de configuração para conexão com o banco de dados
include('config.php');

// Verifica se o ID do paciente foi passado pela URL
if (isset($_GET['id'])) {
    $id_paciente = $_GET['id'];

    // Consulta para pegar os detalhes da anamnese do paciente
    $query_anamnese = "SELECT * FROM anamnese WHERE nome = ?";
    $stmt_anamnese = $conn->prepare($query_anamnese);
    $stmt_anamnese->bind_param("i", $id_paciente);
    $stmt_anamnese->execute();
    $result_anamnese = $stmt_anamnese->get_result();

    // Verifica se a anamnese foi encontrada
    if ($result_anamnese->num_rows > 0) {
        $anamnese = $result_anamnese->fetch_assoc();
    } else {
        echo "Anamnese não encontrada.";
        exit;
    }

    $stmt_anamnese->close();
} else {
    echo "ID de paciente não fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anamnese do Paciente</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .container {
            width: 85%;
            max-width: 1200px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding-bottom: 80px; /* Espaço para o footer não sobrepor o conteúdo */
        }
        footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 12px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .btn-voltar {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }

        .btn-voltar:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #f1f1f1;
        }
        th {
            background-color: #f8f8f8;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        td {
            font-size: 15px;
            color: #555;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        @media screen and (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }
            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Anamnese do Paciente</h1>
    </header>

    <div class="container">
        <h2>Informações da Anamnese</h2>
        <table>
            <tr>
                <th>Data de Avaliação</th>
                <td><?php echo date("d/m/Y", strtotime($anamnese['data_avaliacao'])); ?></td>
            </tr>
            <tr>
                <th>Nome</th>
                <td><?php echo $anamnese['nome']; ?></td>
            </tr>
            <tr>
                <th>Telefone</th>
                <td><?php echo $anamnese['telefone']; ?></td>
            </tr>
            <tr>
                <th>Endereço</th>
                <td><?php echo $anamnese['endereco']; ?></td>
            </tr>
            <tr>
                <th>Peso</th>
                <td><?php echo $anamnese['peso']; ?> kg</td>
            </tr>
            <tr>
                <th>Altura</th>
                <td><?php echo $anamnese['altura']; ?> cm</td>
            </tr>
            <tr>
                <th>Data de Nascimento</th>
                <td><?php echo date("d/m/Y", strtotime($anamnese['data_nascimento'])); ?></td>
            </tr>
            <tr>
                <th>Idade</th>
                <td><?php echo $anamnese['idade']; ?> anos</td>
            </tr>
            <tr>
                <th>Gênero</th>
                <td><?php echo $anamnese['genero']; ?></td>
            </tr>
            <tr>
                <th>Estado Civil</th>
                <td><?php echo $anamnese['estado_civil']; ?></td>
            </tr>
            <tr>
                <th>Número de Gestações</th>
                <td><?php echo $anamnese['numero_gestacoes']; ?></td>
            </tr>
            <tr>
                <th>Número de Filhos</th>
                <td><?php echo $anamnese['numero_filhos']; ?></td>
            </tr>
            <tr>
                <th>Tipos de Partos</th>
                <td><?php echo $anamnese['tipos_partos']; ?></td>
            </tr>
            <tr>
                <th>Nível de Escolaridade</th>
                <td><?php echo $anamnese['nivel_escolaridade']; ?></td>
            </tr>
            <tr>
                <th>Profissão</th>
                <td><?php echo $anamnese['profissao']; ?></td>
            </tr>
            <tr>
                <th>Ocupação</th>
                <td><?php echo $anamnese['ocupacao']; ?></td>
            </tr>
            <tr>
                <th>Atividades Afetadas por Fatores Ambientais</th>
                <td><?php echo $anamnese['atividades_afetadas_fatores_ambientais']; ?></td>
            </tr>
            <tr>
                <th>Observações</th>
                <td><?php echo $anamnese['observacoes']; ?></td>
            </tr>
            <tr>
                <th>Condição Física</th>
                <td><?php echo $anamnese['condicao_fisica']; ?></td>
            </tr>
            <tr>
                <th>Tabagista</th>
                <td><?php echo $anamnese['tabagista'] ? 'Sim' : 'Não'; ?></td>
            </tr>
            <tr>
                <th>Tempo de Tabagismo</th>
                <td><?php echo $anamnese['tempo_tabagismo']; ?> anos</td>
            </tr>
            <tr>
                <th>Etilista</th>
                <td><?php echo $anamnese['etilista'] ? 'Sim' : 'Não'; ?></td>
            </tr>
            <tr>
                <th>Tempo de Etilismo</th>
                <td><?php echo $anamnese['tempo_etilismo']; ?> anos</td>
            </tr>
            <tr>
                <th>Comorbidades</th>
                <td><?php echo $anamnese['comorbidades']; ?></td>
            </tr>
            <tr>
                <th>Medicamentos de Uso Contínuo</th>
                <td><?php echo $anamnese['medicamentos_uso_continuo']; ?></td>
            </tr>
            <tr>
                <th>Medicamentos Atuais</th>
                <td><?php echo $anamnese['medicamentos_atuais']; ?></td>
            </tr>
            <tr>
                <th>Tratamentos Complementares</th>
                <td><?php echo $anamnese['tratamentos_complementares']; ?></td>
            </tr>
            <tr>
                <th>Diagnóstico Clínico</th>
                <td><?php echo $anamnese['diagnostico_clinico']; ?></td>
            </tr>
            <tr>
                <th>CID</th>
                <td><?php echo $anamnese['cid']; ?></td>
            </tr>
            <tr>
                <th>Queixa Principal</th>
                <td><?php echo $anamnese['queixa_principal']; ?></td>
            </tr>
            <tr>
                <th>Outras Queixas</th>
                <td><?php echo $anamnese['outras_queixas']; ?></td>
            </tr>
            <tr>
                <th>História da Doença Atual</th>
                <td><?php echo $anamnese['historia_doenca_atual']; ?></td>
            </tr>
            <tr>
                <th>História da Doença Pregressa</th>
                <td><?php echo $anamnese['historia_doenca_pregressa']; ?></td>
            </tr>
            <tr>
                <th>Antecedentes Cirúrgicos</th>
                <td><?php echo $anamnese['antecedentes_cirurgicos']; ?></td>
            </tr>
            <tr>
                <th>Avaliação Postural</th>
                <td><?php echo $anamnese['avaliacao_postural']; ?></td>
            </tr>
            <tr>
                <th>Inspeção/Palpação</th>
                <td><?php echo $anamnese['inspecao_palpacoa']; ?></td>
            </tr>
            <tr>
                <th>Avaliação da Amplitude de Movimento</th>
                <td><?php echo $anamnese['avaliacao_amplitude_movimento']; ?></td>
            </tr>
            <tr>
                <th>Força Muscular</th>
                <td><?php echo $anamnese['forca_muscular']; ?></td>
            </tr>
            <tr>
                <th>Perimetria</th>
                <td><?php echo $anamnese['perimetria']; ?></td>
            </tr>
            <tr>
                <th>Sensibilidade</th>
                <td><?php echo $anamnese['sensibilidade']; ?></td>
            </tr>
            <tr>
                <th>Diagnóstico Cinesiológico Funcional</th>
                <td><?php echo $anamnese['diagnostico_cinesiologico_funcional']; ?></td>
            </tr>
            <tr>
                <th>Objetivos Terapêuticos</th>
                <td><?php echo $anamnese['objetivos_terapeuticos']; ?></td>
            </tr>
            <tr>
                <th>Conduta Fisioterapêutica</th>
                <td><?php echo $anamnese['conduta_fisioterapeutica']; ?></td>
            </tr>
            <tr>
                <th>Objetivos do Paciente</th>
                <td><?php echo $anamnese['objetivos_paciente']; ?></td>
            </tr>
        </table>

        <a href="detalhes_paciente.php?id=<?php echo $id_paciente; ?>" class="btn-voltar">Voltar para Detalhes do Paciente</a>
    </div>

    <footer>
        <p>&copy; 2024 Sua Instituição</p>
    </footer>

</body>
</html>
