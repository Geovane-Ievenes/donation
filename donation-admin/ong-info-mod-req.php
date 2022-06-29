<?php
include('./head-preview.php');
include('../connection.php');
if(!isset($_GET['req'])) header('location: wellcome.php');

$id_req = $_GET['req'];
    $query_s = 'SELECT ONG.nome_ong, UPPER(USUARIO.nome_usuario) AS nome_proprietario,  DATE_FORMAT(USUARIO.data_criacao_usuario, "%d/%m/%Y") AS data_ativo, ONG.telefone_comercial_ong AS tel_com, ONG.celular_ong AS cel, DATE_FORMAT(SOLICITACAO.data_solicitacao, "%d/%m/%Y") as data_solicitacao_mudanca, SOLICITACAO.id_solicitacao_mudanca as id_solicitacao
                FROM tbperfil_ong AS ONG
                INNER JOIN tbsolicitacao_mudanca as SOLICITACAO
                ON SOLICITACAO.ong_solicitacao = ONG.id_perfil_ong
                INNER JOIN tbusuario as USUARIO
                ON cod_perfil_ong = id_perfil_ong
                WHERE SOLICITACAO.id_solicitacao_mudanca =  ' . $id_req;

    $result = mysqli_query($connection, $query_s);
    if(!$result) echo('Erro: ' . mysqli_error($connection));

    if(mysqli_num_rows($result) == 1) $reg = mysqli_fetch_assoc($result);
?>
<style>
    h3{
        margin-top: 17px;
    }
</style>
</head>

<body>
    <div class="info-container" style="padding-left: 20px;">
        <h2 style="text-align: center; margin-top: 10px;"><?php echo($reg['nome_ong']);?></h2>
        <h3 style="margin: 0px 0px 5px 0px;">Sobre</h3>
        <div class="ong-info">
            <span class="owner-name">Proprietário da ONG: <strong><?php echo($reg['nome_proprietario']);?></strong></span><br>
            <span class="social-reason">Nome da ONG: <strong><?php echo($reg['nome_ong']);?></strong></span><br>
            <span class="active-since">Ativo desde: <strong><?php echo($reg['data_ativo']);?></strong></span><br>
        </div>  

        <h3>Contato</h3>    
        <div class="contacts" style="margin-bottom: 20px;">
            <span class="material-icons"><span class="material-icons-outlined">phone</span></span><span class="tel_com"> [comercial]: <strong><?php echo($reg['tel_com']);?></strong></span><br>
            <span class="material-icons"><span class="material-icons-outlined">phone</span></span><span class="cel"> [celular]: <strong><?php echo($reg['cel']);?></strong></span>
        </div>  
    </div>
</body>
</html>