<?php
    include('./connection.php');
?> 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doações</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=FREDOKA+ONE">
    <!--Materialize-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Roboto;
            background-color: #dfdfdf;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            height: 100vh;
        }
        .form_account {
            width: 1100px;
            min-width: 600px;
            height: 80%;
            border-radius: 1%;
            background: #fff;
            position: fixed;
            top: auto;
            left: auto;
            display: flex;
        }
        .form_account .title_page {
            margin: 0px 0 10px 0;
        }
        .form_account h2 {
            font-family: 'FREDOKA ONE';
            font-size: 25px;
        }
        .form_account h2, .form_account p {
            margin-left: 5px;
        }
        .form_account form .content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .logout{
            position: absolute;
            top: 20px;
            right: 30px;
        }

        .requests{
            width: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid #000;
        }
        .preview{
            width: 50%;
            height: 100%;
            border: 1px solid #000;
        }
        .nav-menu{
            width: 100%;
            height: 10%;
            min-height: 50px;
            font-size: 14pt;
            border: 1px solid #000;
        }

        .ong-content{
            width: 100%;
            height: 90%;
            border: 1px solid #000;
        }

        .nav-inner{
            width: 100%;
            height: 100%;
        }

        .tabs-transparent{
            display: flex;
            justify-content: center;
            justify-content: center;    
        }

        .title-menu{
            height: 10%;
            width: 100%;
            text-align: left;
            font-size: 15pt;
            font-weight: bold;
            border: 1px solid #000;
            padding-top: 10px;
            padding-left: 10px;
        }

        .scroll-requests{
            padding-top: 10px;
            width: 100%;
            height: 100%;
            border: 1px solid #000;
            overflow-y: scroll; 
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .request-item{
            width: 90%;
            min-height: 70px;
            height: 24%;
            border: 1px solid #000;
            border-radius: 1% 1% 1% 1%;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        /*Modify Item*/ 
        .request-item.modify{
            min-height: 70px;
            height: 16%;
            border: 1px solid #000;
            border-radius: 1% 1% 1% 1%;
        }

        .modify-info{
            border: 1px solid #000;
            height: 30%;
            max-height: 60px;
            width: 100%;
            font-size: 9pt;
            font-weight: bold;
            display: flex;
            justify-content: left;
            padding-left: 10px;
        }

        .request-item:hover{
            cursor: pointer;
            border: 1px solid #000;
            box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
            transition: all 0.1s linear;
        }

        .title-rq{
            border: 1px solid #000;
            height: 25%;
            max-height: 60px;
            width: 100%;
            font-size: 13pt;
            font-weight: bold;
            text-align: left;
            padding-left: 10px;
        }

        .info-1{
            border: 1px solid #000;
            height: 21%;
            max-height: 60px;
            width: 100%;
            font-size: 9pt;
            font-weight: bold;
            display: flex;
            justify-content: left;
            padding-left: 10px;
        }

        .info-2{
            width: 100%;
            font-size: 10pt;
            font-style: italic;
            text-align: left;
            padding-left: 10px;
        }

        .iframe{
            height: 100%;
            width: 100%;
        }

        .doacao{
            width: 90%;
            height: 130px;
            background-color:  #fefefe;
            font-size:  16pt;
            display: flex;
            border: 1px solid #000;
            margin-top: 15px;
        }

        .sobre-doacao{
            width: 80%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .doacao-info{
            display: flex;
            justify-content: left;
        }

        .doacao-info-item{
            margin: 0px 10px 0px 10px;
        }

        .acao{
            margin-right:80px;
            width: 20%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-items: center;
        }

        .donate-b{
            margin: 10px 0px 10px 0px;
        }

        .donate-b:disabled{

        }

        .nome{
            padding-left: 10px;
            font-size: 24pt;
        }

        input[type="file"] {
            display: none;
        }      
        input[type="submit"] {
            margin-right:100px;
            margin: 5px;
            text-align: center;
            line-height: 45px;
            color: #fff;
            height: 45px;
            width: 180px;
            border-radius: 10px;
            border: none;
            /*background: #3cb922; Se tiver arquivo*/
            display: inline-block;
            justify-content: center;
            align-items: center;
            cursor: pointer;  
            font-size: 14px;
            font-family: 'FREDOKA ONE';
        }
        input[type="submit"]:disabled{
            background: #c52020; /*Se não tiver arquivo*/
        }
        input[type="submit"]:enabled{
            background: #3cb922; /*Se tiver arquivo*/
        }

        label.input-title {
            margin: 5px;
            text-align: center;
            line-height: 45px;
            color: #fff;
            height: 45px;
            width: 180px;
            background: #54719D;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;  
            font-size: 10px;
            font-family: 'FREDOKA ONE';
        }

        #comprovantes-info{
            margin-left: 10px;
            min-width: 300px;
            width: 90%;
            display: flex;
            justify-content: left;
            align-items: center;
        }

        #link-comprovante{
            display: inline-block;
            margin-right: 20px; 
        }

        p.file-name{
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <span class=""></span>
    <main class="form_account">
        <section class="requests">
            <div class="title-menu">
                <span>Doações pendentes</span>
            </div> 
            <div class="scroll-requests">
                <?php
                    $sql_sel_doacoes = 'SELECT DATE_FORMAT(DOACAO.data_doacao, "%d/%m/%Y") as data_doacao, DOACAO.id_doacao as id, FORMAT(DOACAO.quantia_doacao, 2, \'pt_BR\') AS quantia, COMPROVANTES.arquivo_comprovante as comprovante, UPPER(PROJETO.nome_projeto) as projeto, ONG.nome_ong as ong 
                                        FROM tbdoacao as DOACAO
                                        INNER JOIN tbprojeto as PROJETO
                                        ON DOACAO.id_projeto_doacao = PROJETO.id_projeto
                                        INNER JOIN tbperfil_ong as ONG
                                        ON PROJETO.id_ong_projeto = ONG.id_perfil_ong
                                        INNER JOIN tbcomprovantes as COMPROVANTES
                                        ON DOACAO.id_comprovante_doacao = id_comprovante
                                        WHERE status != 1 AND status != -1
                                        ';
                    $result_doacoes = mysqli_query($connection, $sql_sel_doacoes);
                    if(!$result_doacoes) die('Erro ao buscar doações pendentes: ' . mysqli_error($connection));

                    $c = 0; //file-name id counter
                    while($doacao = mysqli_fetch_assoc($result_doacoes)){
                        echo('
                        <div class="doacao">
                            <div class="sobre-doacao">
                                <section class="nome">Destinatário: '.$doacao['projeto'].'</section>
                                <section class="doacao-info">
                                    <div class="quantia doacao-info-item">R$'.$doacao['quantia'].'</div>
                                    <div class="data doacao-info-item">'.$doacao['data_doacao'].'</div>
                                    <div class="destino doacao-info-item">ONG Destino: '.$doacao['ong'].'</div>
                                </section>
                                <section id="comprovantes-info">
                                    <a href="../comprovantes/'.$doacao['comprovante'].'" target="_blank" id="link-comprovante" download>Comprovante da doação</a>
                                    <div id="file-name-space" style="margin-left: 8px;">
                                        <p class="file-name" id="file-name.'.$c.'"></p>
                                    </div>
                                </section>
                            </div>
                            <div class="acao">
                                <form action="aprovar-pagamento.php" class="form" id="form.'.$c.'" method="POST" id="form" enctype="multipart/form-data">
                                    <input type="hidden" name="id_doacao" value="'.$doacao['id'].'">
                                    <div class="comprovante-container">
                                        <label for="comprovante.'.$c.'" class="input-title">Comprovante de Transferência</label>
                                        <input type="file" name="comprovante-doc" id="comprovante.'.$c.'" class="comprovante">
                                    </div>

                                    <input type="submit" name="aprovar" value="Aprovar" class="donate-b" id="aprove-button.'.$c.'" disabled>
                                </form>
                            </div>
                        </div>
                        ');
                        $c++;
                    }
                    ?>        

                    <!--Precisa tirar o ONCHANGE DO INPUT-->
            </div> 
        </section>
    </main>
    <script src="../js/file-validation.js"></script>
    <script>
        var proofHasBeenInserted = false;
        var validProof = undefined;

        const aproveButton = document.querySelector('#aprove-button');
        const forms = document.querySelectorAll('.form');
        const comprovantes = document.querySelectorAll('.comprovante');

        function switchAproveButton(fileStatus, inputId){
            let submit = document.getElementById(`aprove-button.${inputId.split('.')[1]}`);

            if(fileStatus === true){
                submit.disabled = false;
            }
            else submit.disabled = true;
        }

        function showName(FileInput){
            var FileInputId = FileInput.id.split('.')[1];

            if(typeof FileInput.files[0] !== 'undefined'){
                let fileName = document.getElementById(`file-name.${FileInputId}`);
                fileName.innerText = FileInput.files[0].name;
            }
        }

        comprovantes.forEach((comprovanteItem)=>{
            comprovanteItem.addEventListener('change', (e)=>{
                let inputId = comprovanteItem.id;
                let submit = document.getElementById(`aprove-button.${inputId.split('.')[1]}`);
                let valid = validarArquivo(comprovanteItem, null, 'both', 'proofPopup');

                if(valid){
                    validProof = true;
                    submit.disabled = false;
                    showName(comprovanteItem);
                }
                else submit.disabled = true;
            })
        })

        forms.forEach((form)=>{
            form.addEventListener('submit', (e)=>{
                if(!proofHasBeenInserted){
                    alert('É necessário enviar o comprovante de transferência PIX');
                    e.preventDefault();
                }
                if(validProof == false){
                    alert('O arquivo que você está tentando enviar não é válido');
                    e.preventDefault();
                }
            })
        })
    </script>
</body>
</html>