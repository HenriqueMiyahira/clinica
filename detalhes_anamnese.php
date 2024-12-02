<?php
// Inicia a sessão para garantir que o usuário esteja logado
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["id_usuario"])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: login.php");
    exit;
}

// Inclui o arquivo de configuração para conexão com o banco de dados
include('config.php');

// Verifica se o ID da anamnese foi passado na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID da anamnese não encontrado.";
    exit;
}

$id_anamnese = $_GET['id']; // Captura o ID da anamnese da URL

// Consulta para buscar os detalhes da anamnese
$query = "
    SELECT 
        a.id, a.data_avaliacao, a.nome, a.telefone, a.endereco, a.peso, a.altura, a.data_nascimento, 
        a.idade, a.genero, a.estado_civil, a.numero_gestacoes, a.numero_filhos, a.tipos_partos, 
        a.nivel_escolaridade, a.profissao, a.ocupacao, a.atividades_afetadas_fatores_ambientais, 
        a.observacoes, a.condicao_fisica, a.tabagista, a.tempo_tabagismo, a.etilista, a.tempo_etilismo, 
        a.comorbidades, a.medicamentos_uso_continuo, a.medicamentos_atuais, a.tratamentos_complementares, 
        a.diagnostico_clinico, a.cid, a.queixa_principal, a.outras_queixas, a.historia_doenca_atual, 
        a.historia_doenca_pregressa, a.antecedentes_cirurgicos, a.atividades_afetadas_fatores_ambientais, 
        a.avaliacao_postural, a.inspecao_palpacoa, a.avaliacao_amplitude_movimento, a.informacoes_complementares_amd, 
        a.graduacao_forca_muscular, a.avaliacao_perimetria, a.avaliacao_sensibilidade, a.testes_especiais, 
        a.exames_complementares, a.outras_informacoes, a.diagnostico_cinesiologico_funcional, 
        a.objetivos_terapeuticos, a.conduta_fisioterapeutica, a.objetivos_paciente, a.cabeca, a.ombro, a.clavicula, 
        a.cotovelo, a.antebraco, a.eias, a.eips, a.joelhos, a.patela, a.tornozelos, a.pes, a.coluna_cervical, 
        a.coluna_toracica, a.coluna_lombar, a.observacoes, a.inspecao_palpacao, a.ombro_flexao, a.ombro_extensao, 
        a.cotovelo_flexao, a.cotovelo_extensao, a.radioulnar_pronacao, a.radioulnar_supinacao, a.punho_flexao, 
        a.punho_extensao, a.punho_aducao, a.punho_abducao, a.quadril_flexao, a.quadril_extensao, a.quadril_aducao, 
        a.quadril_abducao, a.quadril_rotacao_medial, a.quadril_rotacao_lateral, a.joelho_flexao, a.joelho_extensao, 
        a.tornozelo_flexao_dorsal, a.tornozelo_flexao_plantar, a.tornozelo_aducao, a.tornozelo_abducao, 
        a.coluna_cervical_flexao, a.coluna_cervical_extensao, a.coluna_cervical_inclinacao_lateral, 
        a.coluna_cervical_rotacao, a.coluna_lombar_flexao, a.coluna_lombar_extensao, a.coluna_lombar_inclinacao_lateral, 
        a.coluna_lombar_rotacao, a.forca_muscular, a.perimetria, a.sensibilidade, a.diagnostico_cinesiologico, 
        a.imagem 
    FROM anamnese a 
    WHERE a.id = ?";

// Prepara a consulta SQL
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_anamnese);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se há algum resultado
if ($result->num_rows > 0) {
    // Obtém os dados da anamnese
    $anamnese = $result->fetch_assoc();
} else {
    echo "Anamnese não encontrada.";
    exit;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Anamnese</title>
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
        .container {
            margin: 20px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        .btn-voltar {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-voltar:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <header>
        <h1>Detalhes da Anamnese</h1>
    </header>

    <div class="container">
        <h2>Anamnese - ID: <?php echo $anamnese['id']; ?></h2>
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
                <td><?php echo $anamnese['inspecao_palpacao']; ?></td>
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
                <td><?php echo $anamnese['diagnostico_cinesiologico']; ?></td>
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
            <tr>
    <th>Imagem</th>
    <td>
        <?php if (!empty($anamnese['imagem'])): ?>
            <img src="<?php echo $anamnese['imagem']; ?>" alt="Imagem da Anamnese" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 5px;">
        <?php else: ?>
            Nenhuma imagem disponível.
        <?php endif; ?>
    </td>
</tr>

        </table>
        
        <button class="btn-voltar" onclick="window.location.href = 'exibir_anamnese.php';">Voltar</button>
    </div>

</body>
</html>
