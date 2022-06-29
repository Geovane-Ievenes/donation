<?php
include('./head-preview.php');
include('../connection.php');
if(!isset($_GET['req'])) header('location: wellcome.php');

$id_req = $_GET['req'];
    $query_s = 'SELECT ONG.nome_ong, UPPER(USUARIO.nome_usuario) AS nome_proprietario, USUARIO.cpf_usuario as cpf_proprietario, DATE_FORMAT(USUARIO.nascimento_usuario, "%d/%m/%Y") AS nascimento_usuario, ONG.CNPJ_ong AS cnpj, DATE_FORMAT(ONG.fundacao_ong, "%d/%m/%Y") as fundacao, ONG.CEP_ong as cep_ong, ONG.descricao_ong as descricao, ONG.telefone_comercial_ong AS tel_com, ONG.celular_ong AS cel
                FROM tbperfil_ong AS ONG
                INNER JOIN tbtentativa_cadastro as SOLICITACAO
                ON SOLICITACAO.id_ong_tentativa = ONG.id_perfil_ong
                INNER JOIN tbusuario as USUARIO
                ON cod_perfil_ong = id_perfil_ong
                WHERE SOLICITACAO.id_tentativa =  ' . $id_req;
    $result = mysqli_query($connection, $query_s);
    if(!$result) echo('Erro: ' . mysqli_error($connection));

    if(mysqli_num_rows($result) == 1) $reg = mysqli_fetch_assoc($result);
    else echo('nada');
?>
<style>
    h3{
        margin-top: 17px;
    }
</style>
<script>
    function formatContact(type, number){
        if(type == 'tel'){
            var r = number.replace(/\D/g, "");
            r = r.replace(/^0/, "");
            if (r.length > 10) {
                r = r.replace(/^(\d\d)(\d{4})(\d{4}).*/, "($1) $2-$3");
            } else if (r.length > 5) {
                r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
            } else if (r.length > 2) {
                r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
            } else {
                r = r.replace(/^(\d*)/, "($1");
            }
            return r;
        }
        else{ // cell
            var r = number.replace(/\D/g, "");
            r = r.replace(/^0/, "");
            if (r.length > 10) {
                r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
            } else if (r.length > 5) {
                r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
            } else if (r.length > 2) {
                r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
            } else {
                r = r.replace(/^(\d*)/, "($1");
            }
            return r;
        }
    }
</script>
</head>

<body>
    <div class="info-container" style="padding-left: 20px;">
        <h2 style="text-align: center; margin-top: 10px;"><?php echo($reg['nome_ong']);?></h2>
        <h3 style="margin: 0px 0px 5px 0px;">Sobre</h3>
        <div class="ong-info">
            <span class="owner-name">Proprietário da ONG: <strong><?php echo($reg['nome_proprietario']);?></strong></span><br>
            <span class="owner-cpf">CPF do proprietário: <strong><?php echo($reg['cpf_proprietario']);?></strong></span><br>
            <span class="owner-birthday">Aniversário do proprietário: <strong><?php echo($reg['nascimento_usuario']);?></strong></span><br>
            <span class="social-reason">Nome da ONG: <strong><?php echo($reg['nome_ong']);?></strong></span><br>
            <span class="cnpj-ong">CNPJ ONG: <strong></strong><?php echo($reg['cnpj']);?></span><br>
            <span class="foundation">Fundação da ONG: <strong><?php echo($reg['fundacao']);?></strong></span><br>
            <span class="CEP">CEP: <strong><?php echo($reg['cep_ong']);?></strong></span><br>
            <h5 style="margin-top: 15px;">Descrição: </h5>
            <textarea class="description-ong" cols="50" rows="8" disabled><?php echo($reg['descricao']);?></textarea>
        </div>  

        <h3>Contato</h3>
        <div class="contacts" style="margin-bottom: 20px;">
            <span class="material-icons"><span class="material-icons-outlined">phone</span></span><span class="tel_com"> [comercial]: <strong><?php echo($reg['tel_com']);?></strong></span><br>
            <span class="material-icons"><span class="material-icons-outlined">phone</span></span><span class="cel"> [celular]: <strong><?php echo($reg['cel']);?></strong></span>
        </div>  
    </div>
</body>
</html>