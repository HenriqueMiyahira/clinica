<?php
// config.php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'clinica');

// Verificando se houve erro na conexão
if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}
?>

<?php
// anamnese.php
include('config.php'); // Incluir a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $data_avaliacao = $_POST['data_avaliacao'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $estado_civil = $_POST['estado_civil'];
    $numero_gestacoes = isset($_POST['numero_gestacoes']) ? $_POST['numero_gestacoes'] : null;
    $numero_filhos = $_POST['numero_filhos'];
    $tipos_partos = $_POST['tipos_partos'];
    $nivel_escolaridade = $_POST['nivel_escolaridade'];
    $profissao = $_POST['profissao'];
    $ocupacao = $_POST['ocupacao'];
    $condicao_fisica = $_POST['condicao_fisica'];
    $tabagista = $_POST['tabagista'];
    $tempo_tabagismo = $_POST['tempo_tabagismo'];
    $etilista = $_POST['etilista'];
    $tempo_etilismo = $_POST['tempo_etilismo'];
    $comorbidades = $_POST['comorbidades'];
    $medicamentos_uso_continuo = $_POST['medicamentos_uso_continuo'];
    $medicamentos_atuais = $_POST['medicamentos_atuais'];
    $tratamentos_complementares = $_POST['tratamentos_complementares'];
    $diagnostico_clinico = $_POST['diagnostico_clinico'];
    $cid = $_POST['cid'];
    $queixa_principal = $_POST['queixa_principal'];
    $outras_queixas = $_POST['outras_queixas'];
    $historia_doenca_atual = $_POST['historia_doenca_atual'];
    $historia_doenca_pregressa = $_POST['historia_doenca_pregressa'];
    $antecedentes_cirurgicos = $_POST['antecedentes_cirurgicos'];
    $atividades_afetadas_fatores_ambientais = $_POST['atividades_afetadas_fatores_ambientais'];
    $avaliacao_postural = isset($_POST['avaliacao_postural']) ? $_POST['avaliacao_postural'] : null;
    $cabeca = $_POST['cabeca'];
    $ombro = $_POST['ombro'];
    $clavicula = $_POST['clavicula'];
    $cotovelo = $_POST['cotovelo'];
    $antebraco = $_POST['antebraco'];
    $eias = $_POST['eias'];
    $eips = $_POST['eips'];
    $joelhos = $_POST['joelhos'];
    $patela = $_POST['patela'];
    $tornozelos = $_POST['tornozelos'];
    $pes = $_POST['pes'];
    $coluna_cervical = $_POST['coluna_cervical'];
    $coluna_toracica = $_POST['coluna_toracica'];
    $coluna_lombar = $_POST['coluna_lombar'];
    $observacoes = $_POST['observacoes'];
    $inspecao_palpacao = isset($_POST['inspecao_palpacao']) ? $_POST['inspecao_palpacao'] : '';
    $ombro_flexao = isset($_POST['ombro_flexao']) ? $_POST['ombro_flexao'] : '';
    $ombro_extensao = isset($_POST['ombro_extensao']) ? $_POST['ombro_extensao'] : '';
    $cotovelo_flexao = isset($_POST['cotovelo_flexao']) ? $_POST['cotovelo_flexao'] : '';
    $cotovelo_extensao = isset($_POST['cotovelo_extensao']) ? $_POST['cotovelo_extensao'] : '';
    $radioulnar_pronacao = isset($_POST['radioulnar_pronacao']) ? $_POST['radioulnar_pronacao'] : '';
    $radioulnar_supinacao = isset($_POST['radioulnar_supinacao']) ? $_POST['radioulnar_supinacao'] : '';
    $punho_flexao = isset($_POST['punho_flexao']) ? $_POST['punho_flexao'] : '';
    $punho_extensao = isset($_POST['punho_extensao']) ? $_POST['punho_extensao'] : '';
    $punho_aducao = isset($_POST['punho_aducao']) ? $_POST['punho_aducao'] : '';
    $punho_abducao = isset($_POST['punho_abducao']) ? $_POST['punho_abducao'] : '';
    $quadril_flexao = isset($_POST['quadril_flexao']) ? $_POST['quadril_flexao'] : '';
    $quadril_extensao = isset($_POST['quadril_extensao']) ? $_POST['quadril_extensao'] : '';
    $quadril_aducao = isset($_POST['quadril_aducao']) ? $_POST['quadril_aducao'] : '';
    $quadril_abducao = isset($_POST['quadril_abducao']) ? $_POST['quadril_abducao'] : '';
    $quadril_rotacao_medial = isset($_POST['quadril_rotacao_medial']) ? $_POST['quadril_rotacao_medial'] : '';
    $quadril_rotacao_lateral = isset($_POST['quadril_rotacao_lateral']) ? $_POST['quadril_rotacao_lateral'] : '';
    $joelho_flexao = isset($_POST['joelho_flexao']) ? $_POST['joelho_flexao'] : '';
    $joelho_extensao = isset($_POST['joelho_extensao']) ? $_POST['joelho_extensao'] : '';
    $tornozelo_flexao_dorsal = isset($_POST['tornozelo_flexao_dorsal']) ? $_POST['tornozelo_flexao_dorsal'] : '';
    $tornozelo_flexao_plantar = isset($_POST['tornozelo_flexao_plantar']) ? $_POST['tornozelo_flexao_plantar'] : '';
    $tornozelo_aducao = isset($_POST['tornozelo_aducao']) ? $_POST['tornozelo_aducao'] : '';
    $tornozelo_abducao = isset($_POST['tornozelo_abducao']) ? $_POST['tornozelo_abducao'] : '';
    $coluna_cervical_flexao = isset($_POST['coluna_cervical_flexao']) ? $_POST['coluna_cervical_flexao'] : '';
    $coluna_cervical_extensao = isset($_POST['coluna_cervical_extensao']) ? $_POST['coluna_cervical_extensao'] : '';
    $coluna_cervical_inclinacao_lateral = isset($_POST['coluna_cervical_inclinacao_lateral']) ? $_POST['coluna_cervical_inclinacao_lateral'] : '';
    $coluna_cervical_rotacao = isset($_POST['coluna_cervical_rotacao']) ? $_POST['coluna_cervical_rotacao'] : '';
    $coluna_lombar_flexao = isset($_POST['coluna_lombar_flexao']) ? $_POST['coluna_lombar_flexao'] : '';
    $coluna_lombar_extensao = isset($_POST['coluna_lombar_extensao']) ? $_POST['coluna_lombar_extensao'] : '';
    $coluna_lombar_inclinacao_lateral = isset($_POST['coluna_lombar_inclinacao_lateral']) ? $_POST['coluna_lombar_inclinacao_lateral'] : '';
    $coluna_lombar_rotacao = isset($_POST['coluna_lombar_rotacao']) ? $_POST['coluna_lombar_rotacao'] : '';
    $informacoes_adm = isset($_POST['informacoes_adm']) ? $_POST['informacoes_adm'] : '';
    $forca_muscular = isset($_POST['forca_muscular']) ? $_POST['forca_muscular'] : '';
    $perimetria = isset($_POST['perimetria']) ? $_POST['perimetria'] : '';
    $sensibilidade = isset($_POST['sensibilidade']) ? $_POST['sensibilidade'] : '';
    $testes_especiais = isset($_POST['testes_especiais']) ? $_POST['testes_especiais'] : '';
    $exames_complementares = isset($_POST['exames_complementares']) ? $_POST['exames_complementares'] : '';
    $outras_informacoes = isset($_POST['outras_informacoes']) ? $_POST['outras_informacoes'] : '';
    $diagnostico_cinesiologico = isset($_POST['diagnostico_cinesiologico']) ? $_POST['diagnostico_cinesiologico'] : '';
    $objetivos_terapeuticos = isset($_POST['objetivos_terapeuticos']) ? $_POST['objetivos_terapeuticos'] : '';
    $conduta_fisioterapeutica = isset($_POST['conduta_fisioterapeutica']) ? $_POST['conduta_fisioterapeutica'] : '';
    $objetivos_paciente = isset($_POST['objetivos_paciente']) ? $_POST['objetivos_paciente'] : '';

    include('config.php'); // Incluir a conexão com o banco de dados

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $imagem = $_FILES['imagem'];
            
            // Exemplo: movendo a imagem para o diretório 'uploads'
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($imagem['name']);
            
            if (move_uploaded_file($imagem['tmp_name'], $uploadFile)) {
                echo "Imagem enviada com sucesso!";
            } else {
                echo "Erro no upload da imagem. Código de erro: " . $imagem['error'];
            }
        } else {
            echo "Nenhuma imagem foi enviada ou ocorreu um erro no envio.";
        }
    }

    

    // Calculando a idade com base na data de nascimento
    $data_nascimento_obj = new DateTime($data_nascimento);
    $data_atual = new DateTime();
    $idade = $data_atual->diff($data_nascimento_obj)->y;

    // Pegando o ID do usuário logado
    $id_usuario = $_SESSION['id_usuario'];

    // Inserir os dados no banco de dados
    $stmt = $mysqli->prepare("INSERT INTO anamnese (
        data_avaliacao, nome, endereco, telefone, peso, altura, data_nascimento, idade, genero, 
        estado_civil, numero_gestacoes, numero_filhos, tipos_partos, nivel_escolaridade, profissao, 
        ocupacao, condicao_fisica, tabagista, tempo_tabagismo, etilista, tempo_etilismo, comorbidades, 
        medicamentos_uso_continuo, medicamentos_atuais, tratamentos_complementares, diagnostico_clinico, 
        cid, queixa_principal, outras_queixas, historia_doenca_atual, historia_doenca_pregressa, 
        antecedentes_cirurgicos, atividades_afetadas_fatores_ambientais, avaliacao_postural, cabeca, 
        ombro, clavicula, cotovelo, antebraco, eias, eips, joelhos, patela, tornozelos, pes, 
        coluna_cervical, coluna_toracica, coluna_lombar, observacoes, inspecao_palpacao, ombro_flexao, 
        ombro_extensao, cotovelo_flexao, cotovelo_extensao, radioulnar_pronacao, radioulnar_supinacao, 
        punho_flexao, punho_extensao, punho_aducao, punho_abducao, quadril_flexao, quadril_extensao, 
        quadril_aducao, quadril_abducao, quadril_rotacao_medial, quadril_rotacao_lateral, joelho_flexao, 
        joelho_extensao, tornozelo_flexao_dorsal, tornozelo_flexao_plantar, tornozelo_aducao, 
        tornozelo_abducao, coluna_cervical_flexao, coluna_cervical_extensao, coluna_cervical_inclinacao_lateral, 
        coluna_cervical_rotacao, coluna_lombar_flexao, coluna_lombar_extensao, coluna_lombar_inclinacao_lateral, 
        coluna_lombar_rotacao, informacoes_adm, forca_muscular, perimetria, sensibilidade, testes_especiais, 
        exames_complementares, outras_informacoes, diagnostico_cinesiologico, objetivos_terapeuticos, 
        conduta_fisioterapeutica, objetivos_paciente, id_usuario
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )");
    
    $tipos = str_repeat('s', 57) . str_repeat('i', 33) . 'dd';  // Ajustar conforme os tipos de dados
    $valores = [ 
        $data_avaliacao, $nome, $endereco, $telefone, $peso, $altura, $data_nascimento, $idade, $genero, 
        $estado_civil, $numero_gestacoes, $numero_filhos, $tipos_partos, $nivel_escolaridade, $profissao, 
        $ocupacao, $condicao_fisica, $tabagista, $tempo_tabagismo, $etilista, $tempo_etilismo, $comorbidades, 
        $medicamentos_uso_continuo, $medicamentos_atuais, $tratamentos_complementares, $diagnostico_clinico, 
        $cid, $queixa_principal, $outras_queixas, $historia_doenca_atual, $historia_doenca_pregressa, 
        $antecedentes_cirurgicos, $atividades_afetadas_fatores_ambientais, $avaliacao_postural, $cabeca, 
        $ombro, $clavicula, $cotovelo, $antebraco, $eias, $eips, $joelhos, $patela, $tornozelos, $pes, 
        $coluna_cervical, $coluna_toracica, $coluna_lombar, $observacoes, $inspecao_palpacao, $ombro_flexao, 
        $ombro_extensao, $cotovelo_flexao, $cotovelo_extensao, $radioulnar_pronacao, $radioulnar_supinacao, 
        $punho_flexao, $punho_extensao, $punho_aducao, $punho_abducao, $quadril_flexao, $quadril_extensao, 
        $quadril_aducao, $quadril_abducao, $quadril_rotacao_medial, $quadril_rotacao_lateral, $joelho_flexao, 
        $joelho_extensao, $tornozelo_flexao_dorsal, $tornozelo_flexao_plantar, $tornozelo_aducao, 
        $tornozelo_abducao, $coluna_cervical_flexao, $coluna_cervical_extensao, $coluna_cervical_inclinacao_lateral, 
        $coluna_cervical_rotacao, $coluna_lombar_flexao, $coluna_lombar_extensao, $coluna_lombar_inclinacao_lateral, 
        $coluna_lombar_rotacao, $informacoes_adm, $forca_muscular, $perimetria, $sensibilidade, $testes_especiais, 
        $exames_complementares, $outras_informacoes, $diagnostico_cinesiologico, $objetivos_terapeuticos, 
        $conduta_fisioterapeutica, $objetivos_paciente, $id_usuario
        
    ];
   
    
    // Vincule os parâmetros
    $stmt->bind_param($tipos, ...$valores);
    $stmt->execute();
$stmt->close();

echo "Anamnese salva com sucesso!";
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Anamnese</title>
    <script>
        // Função para exibir ou ocultar campos de gestação e filhos
        function toggleGestacaoFields() {
            var genero = document.querySelector('input[name="genero"]:checked').value;
            var gestacaoFields = document.getElementById("gestacao_fields");

            if (genero === "Masculino") {
                gestacaoFields.style.display = "none";
            } else {
                gestacaoFields.style.display = "block";
            }
        }

        // Chama a função quando a página carrega para ajustar a visibilidade
        window.onload = function() {
            toggleGestacaoFields();
        }
    </script>
    <script>
        // Função para exibir ou ocultar campos de atividade física
        function toggleAtividadeFields() {
            var condicao_fisica = document.querySelector('input[name="condicao_fisica"]:checked').value;
            var atividadeFields = document.getElementById("atividade_fields");

            if (condicao_fisica === "Sedentário") {
                atividadeFields.style.display = "none";
            } else {
                atividadeFields.style.display = "block";
            }
        }

        // Chama a função quando a página carrega para ajustar a visibilidade
        window.onload = function() {
            toggleAtividadeFields();
        }
        function toggleTabagistaFields() {
            var tabagista = document.querySelector('input[name="tabagista"]:checked').value;
            var tabagismoFields = document.getElementById("tabagismo_fields");

            if (tabagista === "Sim") {
                tabagismoFields.style.display = "block";
            } else {
                tabagismoFields.style.display = "none";
            }
        }

        // Função para exibir ou ocultar campos de etilismo
        function toggleEtilistaFields() {
            var etilista = document.querySelector('input[name="etilista"]:checked').value;
            var etilismoFields = document.getElementById("etilismo_fields");

            if (etilista === "Sim") {
                etilismoFields.style.display = "block";
            } else {
                etilismoFields.style.display = "none";
            }
        }

        // Chama as funções ao carregar a página para ajustar as visibilidades
        window.onload = function() {
            toggleAtividadeFields();
            toggleTabagistaFields();
            toggleEtilistaFields();
        }
    </script>
    </script>
    <style>
        /* Estilo para os botões de seleção (estilo como no Tabagista) */
        .select-group {
            display: flex;
            gap: 10px;
        }

        .select-group input {
            display: none;
        }

        .select-group label {
            padding: 10px 20px;
            border: 2px solid #ccc;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .select-group input:checked + label {
            background-color: #4CAF50;
            color: white;
        }

        .select-group label:hover {
            background-color: #ddd;
        }

        .select-group input:checked + label:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    

   

    <form action="anamnese.php" method="POST" enctype="multipart/form-data">
        <!-- Dados Pessoais -->
        <label for="data_avaliacao">Data da Avaliação:</label>
        <input type="date" name="data_avaliacao" value="<?php echo date('Y-m-d'); ?>" readonly><br><br>

        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br><br>

        <label for="endereco">Endereço:</label>
        <textarea name="endereco" required></textarea><br><br>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" required><br><br>

        <label for="peso">Peso:</label>
        <input type="number" step="0.01" name="peso" required><br><br>

        <label for="altura">Altura:</label>
        <input type="number" step="0.01" name="altura" required><br><br>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" required><br><br>

        <label for="genero">Gênero:</label><br>
        <div class="select-group">
            <input type="radio" id="masculino" name="genero" value="Masculino" onchange="toggleGestacaoFields()" required>
            <label for="masculino">Masculino</label>

            <input type="radio" id="feminino" name="genero" value="Feminino" onchange="toggleGestacaoFields()" required>
            <label for="feminino">Feminino</label>

            <input type="radio" id="outro" name="genero" value="Outro" onchange="toggleGestacaoFields()" required>
            <label for="outro">Outro</label>
        </div><br><br>

        <!-- Campos Condicionais para Mulheres e Outros Gêneros -->
        <div id="gestacao_fields" style="display:none;">
            <label for="gestacao">Número de Gestações:</label>
            <input type="number" name="gestacao" min="0"><br><br>

            <label for="numero_filhos">Número de Filhos:</label>
            <input type="number" name="numero_filhos" min="0"><br><br>

            <label for="tipos_partos">Tipos de Partos:</label>
            <textarea name="tipos_partos"></textarea><br><br>
        </div>

        <!-- Estado Civil -->
        <label for="estado_civil">Estado Civil:</label><br>
        <select name="estado_civil" required>
            <option value="Solteiro">Solteiro</option>
            <option value="Casado">Casado</option>
            <option value="Separado Judicialmente">Separado Judicialmente</option>
            <option value="Divorciado">Divorciado</option>
            <option value="Viúvo">Viúvo</option>
        </select><br><br>

        <label for="nivel_escolaridade">Nível de Escolaridade:</label>
        <input type="text" name="nivel_escolaridade" required><br><br>

        <label for="profissao">Profissão:</label>
        <input type="text" name="profissao" required><br><br>

        <label for="ocupacao">Ocupação:</label>
        <input type="text" name="ocupacao" required><br><br>

         <!-- Condição Física -->
         <label for="condicao_fisica">Condição Física:</label><br>
        <div class="select-group">
            <input type="radio" id="sedentario" name="condicao_fisica" value="Sedentário" onchange="toggleAtividadeFields()" required>
            <label for="sedentario">Sedentário</label>

            <input type="radio" id="atividade_fisica" name="condicao_fisica" value="Pratica atividade física" onchange="toggleAtividadeFields()" required>
            <label for="atividade_fisica">Pratica atividade física</label>
        </div><br><br>

        <!-- Campos Condicionais para "Pratica atividade física" -->
        <div id="atividade_fields" style="display:none;">
            <label for="quantidade_atividade">Quantidade na semana:</label>
            <input type="number" name="quantidade_atividade" min="1"><br><br>
        </div>

        <!-- Tabagista -->
        <label for="tabagista">Tabagista:</label><br>
        <div class="select-group">
            <input type="radio" id="tabagista_sim" name="tabagista" value="Sim" onchange="toggleTabagistaFields()" required>
            <label for="tabagista_sim">Sim</label>

            <input type="radio" id="tabagista_nao" name="tabagista" value="Não" onchange="toggleTabagistaFields()" required>
            <label for="tabagista_nao">Não</label>
        </div><br><br>

        <!-- Campo de Tempo de Tabagismo -->
        <div id="tabagismo_fields" style="display:none;">
            <label for="tempo_tabagismo">Quanto tempo?</label>
            <input type="text" name="tempo_tabagismo"><br><br>
        </div>

        <!-- Etilista -->
        <label for="etilista">Etilista:</label><br>
        <div class="select-group">
            <input type="radio" id="etilista_sim" name="etilista" value="Sim" onchange="toggleEtilistaFields()" required>
            <label for="etilista_sim">Sim</label>

            <input type="radio" id="etilista_nao" name="etilista" value="Não" onchange="toggleEtilistaFields()" required>
            <label for="etilista_nao">Não</label>
        </div><br><br>

        <!-- Campo de Tempo de Etilismo -->
        <div id="etilismo_fields" style="display:none;">
            <label for="tempo_etilismo">Quanto tempo?</label>
            <input type="text" name="tempo_etilismo"><br><br>
        </div>


        <!-- Comorbidades, Medicamentos, Diagnóstico, etc. -->
        <label for="comorbidades">Comorbidades:</label>
        <textarea name="comorbidades"></textarea><br><br>

        <label for="medicamentos_uso_continuo">Medicamentos de Uso Contínuo:</label>
        <textarea name="medicamentos_uso_continuo"></textarea><br><br>

        <label for="medicamentos_atuais">Medicamentos Atuais:</label>
        <textarea name="medicamentos_atuais"></textarea><br><br>

        <label for="tratamentos_complementares">Tratamentos Complementares:</label>
        <textarea name="tratamentos_complementares"></textarea><br><br>

        <label for="diagnostico_clinico">Diagnóstico Clínico:</label>
        <textarea name="diagnostico_clinico"></textarea><br><br>

        <label for="cid">CID:</label>
        <input type="text" name="cid"><br><br>

        <label for="queixa_principal">Queixa Principal:</label>
        <textarea name="queixa_principal" required></textarea><br><br>

        <label for="outras_queixas">Outras Queixas:</label>
        <textarea name="outras_queixas"></textarea><br><br>

        <!-- História da Doença e Outros Campos -->
        <label for="historia_doenca_atual">História da Doença Atual (HDA):</label>
        <textarea name="historia_doenca_atual"></textarea><br><br>

        <label for="historia_doenca_pregressa">História da Doença Pregressa (HDP):</label>
        <textarea name="historia_doenca_pregressa"></textarea><br><br>

        <label for="antecedentes_cirurgicos">Antecedentes Cirúrgicos:</label>
        <textarea name="antecedentes_cirurgicos"></textarea><br><br>

        <label for="atividades_afetadas_fatores_ambientais">Atividades Afetadas e Influência de Fatores Ambientais:</label>
        <textarea name="atividades_afetadas_fatores_ambientais"></textarea><br><br>

        <h3>Avaliação Postural</h3>
    
    <label for="cabeca">Cabeça:</label><br>
    <input type="radio" name="cabeca" value="Alinhada"> Alinhada
    <input type="radio" name="cabeca" value="Rodada"> Rodada
    <input type="radio" name="cabeca" value="Inclinada"> Inclinada<br><br>

    <label for="ombro">Ombro:</label><br>
    <input type="radio" name="ombro" value="Alinhado"> Alinhado
    <input type="radio" name="ombro" value="Elevado D"> Elevado D
    <input type="radio" name="ombro" value="Elevado E"> Elevado E
    <input type="radio" name="ombro" value="Deprimido D"> Deprimido D
    <input type="radio" name="ombro" value="Deprimido E"> Deprimido E<br><br>

    <label for="clavicula">Clavícula:</label><br>
    <input type="radio" name="clavicula" value="Alinhada"> Alinhada
    <input type="radio" name="clavicula" value="Elevada D"> Elevada D
    <input type="radio" name="clavicula" value="Elevada E"> Elevada E
    <input type="radio" name="clavicula" value="Saliente D"> Saliente D
    <input type="radio" name="clavicula" value="Saliente E"> Saliente E<br><br>

    <label for="cotovelo">Cotovelo:</label><br>
    <input type="radio" name="cotovelo" value="Alinhado"> Alinhado
    <input type="radio" name="cotovelo" value="Valgo D"> Valgo D
    <input type="radio" name="cotovelo" value="Valgo E"> Valgo E
    <input type="radio" name="cotovelo" value="Varo D"> Varo D
    <input type="radio" name="cotovelo" value="Varo E"> Varo E<br><br>

    <label for="antebraco">Antebraço:</label><br>
    <input type="radio" name="antebraco" value="Neutros"> Neutros
    <input type="radio" name="antebraco" value="Pronado D"> Pronado D
    <input type="radio" name="antebraco" value="Pronado E"> Pronado E
    <input type="radio" name="antebraco" value="Supinado D"> Supinado D
    <input type="radio" name="antebraco" value="Supinado E"> Supinado E<br><br>

    <label for="eias">EIAS:</label><br>
    <input type="radio" name="eias" value="Alinhada"> Alinhada
    <input type="radio" name="eias" value="Mais baixa D"> Mais baixa D
    <input type="radio" name="eias" value="Mais baixa E"> Mais baixa E<br><br>

    <label for="eips">EIPS:</label><br>
    <input type="radio" name="eips" value="Alinhada"> Alinhada
    <input type="radio" name="eips" value="Mais baixa D"> Mais baixa D
    <input type="radio" name="eips" value="Mais baixa E"> Mais baixa E<br><br>

    <label for="joelhos">Joelhos:</label><br>
    <input type="radio" name="joelhos" value="Alinhados"> Alinhados
    <input type="radio" name="joelhos" value="Valgo D"> Valgo D
    <input type="radio" name="joelhos" value="Valgo E"> Valgo E
    <input type="radio" name="joelhos" value="Varo D"> Varo D
    <input type="radio" name="joelhos" value="Varo E"> Varo E
    <input type="radio" name="joelhos" value="Rot. Medial D"> Rot. Medial D
    <input type="radio" name="joelhos" value="Rot. Medial E"> Rot. Medial E
    <input type="radio" name="joelhos" value="Rot. Lateral D"> Rot. Lateral D
    <input type="radio" name="joelhos" value="Rot. Lateral E"> Rot. Lateral E<br><br>

    <label for="patela">Patela:</label><br>
    <input type="radio" name="patela" value="Alinhada"> Alinhada
    <input type="radio" name="patela" value="Lateralizada D"> Lateralizada D
    <input type="radio" name="patela" value="Lateralizada E"> Lateralizada E
    <input type="radio" name="patela" value="Medializada D"> Medializada D
    <input type="radio" name="patela" value="Medializada E"> Medializada E
    <input type="radio" name="patela" value="Elevada D"> Elevada D
    <input type="radio" name="patela" value="Elevada E"> Elevada E<br><br>

    <label for="tornozelos">Tornozelos:</label><br>
    <input type="radio" name="tornozelos" value="Alinhados"> Alinhados
    <input type="radio" name="tornozelos" value="Valgo D"> Valgo D
    <input type="radio" name="tornozelos" value="Valgo E"> Valgo E
    <input type="radio" name="tornozelos" value="Varo D"> Varo D
    <input type="radio" name="tornozelos" value="Varo E"> Varo E<br><br>

    <label for="pes">Pés:</label><br>
    <input type="radio" name="pes" value="Alinhados"> Alinhados
    <input type="radio" name="pes" value="Valgo D"> Valgo D
    <input type="radio" name="pes" value="Valgo E"> Valgo E
    <input type="radio" name="pes" value="Varo D"> Varo D
    <input type="radio" name="pes" value="Varo E"> Varo E
    <input type="radio" name="pes" value="Plano D"> Plano D
    <input type="radio" name="pes" value="Plano E"> Plano E
    <input type="radio" name="pes" value="Cavo D"> Cavo D
    <input type="radio" name="pes" value="Cavo E"> Cavo E<br><br>

    <label for="coluna_cervical">Coluna Cervical:</label><br>
    <input type="radio" name="coluna_cervical" value="Retificada"> Retificada
    <input type="radio" name="coluna_cervical" value="Normal"> Normal
    <input type="radio" name="coluna_cervical" value="Hiperlordose"> Hiperlordose<br><br>

    <label for="coluna_toracica">Coluna Torácica:</label><br>
    <input type="radio" name="coluna_toracica" value="Retificada"> Retificada
    <input type="radio" name="coluna_toracica" value="Normal"> Normal
    <input type="radio" name="coluna_toracica" value="Hipercifose"> Hipercifose<br><br>

    <label for="coluna_lombar">Coluna Lombar:</label><br>
    <input type="radio" name="coluna_lombar" value="Retificada"> Retificada
    <input type="radio" name="coluna_lombar" value="Normal"> Normal
    <input type="radio" name="coluna_lombar" value="Hiperlordose"> Hiperlordose<br><br>

    <label for="observacoes">Observações sobre Avaliação Postural:</label><br>
    <textarea name="observacoes" id="observacoes" rows="4" cols="50"></textarea>
    <br><br>

    <form action="anamnese.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="imagem" required>

    <label for="inspecao_palpacao">Inspeção e Palpação:</label><br>
        <textarea id="inspecao_palpacao" name="inspecao_palpacao" rows="4" cols="50"></textarea><br><br>

        <h3>Avaliação de Amplitude de Movimento (ADM) - Membros Superiores</h3>
        <label for="ombro_flexao">Ombro - Flexão:</label>
        <input type="number" id="ombro_flexao" name="ombro_flexao"><br><br>

        <label for="ombro_extensao">Ombro - Extensão:</label>
        <input type="number" id="ombro_extensao" name="ombro_extensao"><br><br>

        <label for="cotovelo_flexao">Cotovelo - Flexão:</label>
        <input type="number" id="cotovelo_flexao" name="cotovelo_flexao"><br><br>

        <label for="cotovelo_extensao">Cotovelo - Extensão:</label>
        <input type="number" id="cotovelo_extensao" name="cotovelo_extensao"><br><br>

        <label for="radioulnar_pronacao">Radioulnar - Pronação:</label>
        <input type="number" id="radioulnar_pronacao" name="radioulnar_pronacao"><br><br>

        <label for="radioulnar_supinacao">Radioulnar - Supinação:</label>
        <input type="number" id="radioulnar_supinacao" name="radioulnar_supinacao"><br><br>

        <label for="punho_flexao">Punho - Flexão:</label>
        <input type="number" id="punho_flexao" name="punho_flexao"><br><br>

        <label for="punho_extensao">Punho - Extensão:</label>
        <input type="number" id="punho_extensao" name="punho_extensao"><br><br>

        <label for="punho_aducao">Punho - Adução:</label>
        <input type="number" id="punho_aducao" name="punho_aducao"><br><br>

        <label for="punho_abducao">Punho - Abdução:</label>
        <input type="number" id="punho_abducao" name="punho_abducao"><br><br>

        <h3>Membros Inferiores</h3>
        <label for="quadril_flexao">Quadril - Flexão:</label>
        <input type="number" id="quadril_flexao" name="quadril_flexao"><br><br>

        <label for="quadril_extensao">Quadril - Extensão:</label>
        <input type="number" id="quadril_extensao" name="quadril_extensao"><br><br>

        <label for="quadril_aducao">Quadril - Adução:</label>
        <input type="number" id="quadril_aducao" name="quadril_aducao"><br><br>

        <label for="quadril_abducao">Quadril - Abdução:</label>
        <input type="number" id="quadril_abducao" name="quadril_abducao"><br><br>

        <label for="quadril_rotacao_medial">Quadril - Rotação Medial:</label>
        <input type="number" id="quadril_rotacao_medial" name="quadril_rotacao_medial"><br><br>

        <label for="quadril_rotacao_lateral">Quadril - Rotação Lateral:</label>
        <input type="number" id="quadril_rotacao_lateral" name="quadril_rotacao_lateral"><br><br>

        <label for="joelho_flexao">Joelho - Flexão:</label>
        <input type="number" id="joelho_flexao" name="joelho_flexao"><br><br>

        <label for="joelho_extensao">Joelho - Extensão:</label>
        <input type="number" id="joelho_extensao" name="joelho_extensao"><br><br>

        <label for="tornozelo_flexao_dorsal">Tornozelo - Flexão Dorsal:</label>
        <input type="number" id="tornozelo_flexao_dorsal" name="tornozelo_flexao_dorsal"><br><br>

        <label for="tornozelo_flexao_plantar">Tornozelo - Flexão Plantar:</label>
        <input type="number" id="tornozelo_flexao_plantar" name="tornozelo_flexao_plantar"><br><br>

        <label for="tornozelo_aducao">Tornozelo - Adução:</label>
        <input type="number" id="tornozelo_aducao" name="tornozelo_aducao"><br><br>

        <label for="tornozelo_abducao">Tornozelo - Abdução:</label>
        <input type="number" id="tornozelo_abducao" name="tornozelo_abducao"><br><br>

        <h3>Coluna</h3>
        <label for="coluna_cervical_flexao">Coluna Cervical - Flexão:</label>
        <input type="number" id="coluna_cervical_flexao" name="coluna_cervical_flexao"><br><br>

        <label for="coluna_cervical_extensao">Coluna Cervical - Extensão:</label>
        <input type="number" id="coluna_cervical_extensao" name="coluna_cervical_extensao"><br><br>

        <label for="coluna_cervical_inclinacao_lateral">Coluna Cervical - Inclinação Lateral:</label>
        <input type="number" id="coluna_cervical_inclinacao_lateral" name="coluna_cervical_inclinacao_lateral"><br><br>

        <label for="coluna_cervical_rotacao">Coluna Cervical - Rotação:</label>
        <input type="number" id="coluna_cervical_rotacao" name="coluna_cervical_rotacao"><br><br>

        <label for="coluna_lombar_flexao">Coluna Lombar - Flexão:</label>
        <input type="number" id="coluna_lombar_flexao" name="coluna_lombar_flexao"><br><br>

        <label for="coluna_lombar_extensao">Coluna Lombar - Extensão:</label>
        <input type="number" id="coluna_lombar_extensao" name="coluna_lombar_extensao"><br><br>

        <label for="coluna_lombar_inclinacao_lateral">Coluna Lombar - Inclinação Lateral:</label>
        <input type="number" id="coluna_lombar_inclinacao_lateral" name="coluna_lombar_inclinacao_lateral"><br><br>

        <label for="coluna_lombar_rotacao">Coluna Lombar - Rotação:</label>
        <input type="number" id="coluna_lombar_rotacao" name="coluna_lombar_rotacao"><br><br>

        <h3>Informações Complementares</h3>
        <label for="informacoes_adm">Informações Complementares de ADM:</label><br>
        <textarea id="informacoes_adm" name="informacoes_adm" rows="4" cols="50"></textarea><br><br>

        <label for="forca_muscular">Força Muscular:</label><br>
        <textarea id="forca_muscular" name="forca_muscular" rows="4" cols="50"></textarea><br><br>

        <label for="perimetria">Perimetria:</label><br>
        <textarea id="perimetria" name="perimetria" rows="4" cols="50"></textarea><br><br>

        <label for="sensibilidade">Sensibilidade:</label><br>
        <textarea id="sensibilidade" name="sensibilidade" rows="4" cols="50"></textarea><br><br>

        <label for="testes_especiais">Testes Especiais / Funcionais:</label><br>
        <textarea id="testes_especiais" name="testes_especiais" rows="4" cols="50"></textarea><br><br>

        <label for="exames_complementares">Exames Complementares:</label><br>
        <textarea id="exames_complementares" name="exames_complementares" rows="4" cols="50"></textarea><br><br>

        <label for="outras_informacoes">Outras Informações:</label><br>
        <textarea id="outras_informacoes" name="outras_informacoes" rows="4" cols="50"></textarea><br><br>

        <label for="diagnostico_cinesiologico">Diagnóstico Cinesiológico:</label><br>
        <textarea id="diagnostico_cinesiologico" name="diagnostico_cinesiologico" rows="4" cols="50"></textarea><br><br>

        <label for="objetivos_terapeuticos">Objetivos Terapêuticos:</label><br>
        <textarea id="objetivos_terapeuticos" name="objetivos_terapeuticos" rows="4" cols="50"></textarea><br><br>

        <label for="conduta_fisioterapeutica">Conduta Fisioterapêutica:</label><br>
        <textarea id="conduta_fisioterapeutica" name="conduta_fisioterapeutica" rows="4" cols="50"></textarea><br><br>

        <label for="objetivos_paciente">Objetivos do Paciente:</label><br>
        <textarea id="objetivos_paciente" name="objetivos_paciente" rows="4" cols="50"></textarea><br><br>

        <label for="id_usuario">ID do Usuário:</label>
        <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>"><br><br>


        <button type="submit">Salvar Anamnese</button>
    </form>
    
</body>
</html>
