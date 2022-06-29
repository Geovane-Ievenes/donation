
<?php
include('./head-preview.php');
include('../connection.php');
if(!isset($_GET['req'])) header('location: wellcome.php');

$id_req = $_GET['req']; 
$proj_id = $_GET['p'];

$query_s = 'SELECT PROJETO.logo_projeto, PROJETO.nome_projeto AS nome_antigo, PROJETO.descricao_projeto AS descricao_antiga, SOLICITACAO.valores_novos
FROM tbsolicitacao_mudanca as SOLICITACAO
INNER JOIN tbprojeto as PROJETO
ON SOLICITACAO.projeto_solicitacao = PROJETO.id_projeto
WHERE id_solicitacao_mudanca =  ' . $id_req;

$result = mysqli_query($connection, $query_s);
if(!$result) die('Erro: ' . mysqli_error($connection));

$reg = mysqli_fetch_assoc($result);

$valores_novos_arr = json_decode($reg['valores_novos'], true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sla</title>
    <link rel="stylesheet" href="../slider/slider-no-fade.css">
    <link rel="stylesheet" href="../slider/slider-removed-show.css">
    <style>
        .seta{
            font-size: 12px;
        }

        .descricoes{
            display: flex;
            align-items: center;
        }

        .slides-novos{
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .slides-removidos{
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .slides-novos-container{
            width: 85%;
        }

        .slides-removidos-container{
            width: 85%;
        }
    </style>
</head>

<body>

    <div class="info-container" style="padding-left: 20px;">
        <h2 style="text-align: center; margin-top: 10p  x;">Solicitação n° <?php echo($id_req);?></h2>
        <?php

            if(array_key_exists('nome_projeto', $valores_novos_arr)){
                echo('
                <h4>Alteração do nome do projeto:</h4>
                <span class="nome-antigo" style="margin-right: 15px;">'.$reg['nome_antigo'].'</span><span class="material-icons seta">east</span><span class="nome-novo" style="margin-left: 15px;">'.$valores_novos_arr['nome_projeto'].'</span><br>
                ');
            }

            if(array_key_exists('descricao_projeto', $valores_novos_arr)){
                echo('
                <h4>Alteração da descrição do projeto:</h4>
                <div class="descricoes">
                    <textarea name="" id="" cols="25" rows="7" class="descricao_antiga">'.$reg['descricao_antiga'].'</textarea>
                    <span class="material-icons seta" style="margin: 0px 10px 0px 10px;">east</span>
                    <textarea name="" id="" cols="25" rows="7" class="descricao_">'.$valores_novos_arr['descricao_projeto'].'</textarea>
                </div>
                ');
            }
        ?>

        <div class="sliders-novos">
            <div class="slides-novos-container">
                <?php 
                    $sql_s = 'SELECT * FROM tbsolicitacao_mudanca WHERE id_solicitacao_mudanca = '. $id_req;
                    $result_req = mysqli_query($connection, $sql_s);
                    if(!$result_req){
                    die('Não foi possível encontrar as imagens da solicitação (1), desculpe :(');
                    }
                
                    //Nenhuma solicitação encontrada
                    if(mysqli_num_rows($result_req) == 0) header('location: wellcome.php');
                
                    //soliciutação encontrada
                    $reg = mysqli_fetch_assoc($result_req);
                
                    $img_novas = json_decode($reg['imagens_novas'], true);
                    $img_existentes = json_decode($reg['imagens_existentes'], true);
                
                    //Se não houverem imagens novas, então não exiba o slider
                    if(!empty($img_novas)){
                        echo('<h3>Mural de imagens atualizado</h3>');

                        include('../slider/slider-just-show.php');
                    }
                    else {
                        echo('
                            <h3>Mural de imagens atualizado</h3>
                            <h5 style="margin-bottom: 15px;"><b>*Nenhuma foto foi adicionada*</b></h5>
                        ');
                    }
                ?>
                <script src="../slider/slider-just-show.js"></script>
            </div>
        </div>
        <div class="sliders-removidos">
            <div class="slides-removidos-container">
                <?php 
                    $sql_s = 'SELECT * FROM tbsolicitacao_mudanca WHERE id_solicitacao_mudanca = '. $id_req;
                    $result_req = mysqli_query($connection, $sql_s);
                    if(!$result_req){
                    die('Não foi possível encontrar as imagens da solicitação (2), desculpe :(');
                    }
                
                    //Nenhuma solicitação encontrada
                    if(mysqli_num_rows($result_req) == 0) header('location: wellcome.php');
                
                    //soliciutação encontrada
                    $reg = mysqli_fetch_assoc($result_req);
                
                    $img_apagadas = json_decode($reg['imagens_apagadas'], true);
                
                    //Se não houverem imagens apagadas, então não exiba o slider
                    if(!empty($img_apagadas)){
                        echo('<h3>Fotos Apagadas</h3>');

                        include('../slider/slider-removed-show.php');
                    }
                ?>
                <script src="../slider/slider-removed-show.js"></script>
            </div>
        </div>
    </div>
</body>
</html>