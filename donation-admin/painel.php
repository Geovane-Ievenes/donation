<?php
    session_start();
    if(!isset($_SESSION['adm'])){
        header('location: index.php');
    }

    include('../connection.php');
    $query_s = 'SELECT ONG.id_perfil_ong as id_ong, UPPER(ONG.nome_ong) AS nome, ONG.descricao_ong as descricao, DATE_FORMAT(SOLICITACAO.data_tentativa, "%d/%m/%Y") as data_solicitacao, SOLICITACAO.id_tentativa as id_solicitacao, SOLICITACAO.situacao_tentativa AS status_solicitacao
                FROM tbperfil_ong AS ONG
                INNER JOIN tbtentativa_cadastro as SOLICITACAO
                ON id_ong_tentativa = ONG.id_perfil_ong;';
    $result = mysqli_query($connection, $query_s);
    if(!$result){
        echo('Erro: ' . mysqli_error($connection));
        exit;
    }

    $query_mod_solicitacoes = 'SELECT ONG.id_perfil_ong as id_ong, SOLICITACAO.projeto_solicitacao AS id_projeto, UPPER(ONG.nome_ong) AS nome, DATE_FORMAT(SOLICITACAO.data_solicitacao, "%d/%m/%Y") as data_solicitacao_mudanca, SOLICITACAO.id_solicitacao_mudanca as id_solicitacao, SOLICITACAO.status_solicitacao AS status_solicitacao
                               FROM tbsolicitacao_mudanca AS SOLICITACAO 
                               INNER JOIN tbperfil_ong AS ONG 
                               ON solicitacao.ong_solicitacao = ONG.id_perfil_ong;';
    $result_mod = mysqli_query($connection, $query_mod_solicitacoes);
    if(!$result_mod){
        die('Erro ao buscar novas requisições de revisão: ' . mysqli_error($connection));
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-Se</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=FREDOKA+ONE">
    <!--Materialize-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="style_painel.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style>
        .logout{
            position: absolute;
            top: 20px;
            right: 30px;
        }

        .doacoes{
            position: absolute;
            top: 20px;
            right: 120px;
        }

        .requests{
            width: 50%;
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
            height: 90%;
            border: 1px solid #000;
            overflow-y: scroll;
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
    </style>
</head>
<body>
    <div class="background-div"></div>
    <span class="doacoes"><a href="./doacoes.php">Doações</a></span>
    <span class="logout"><a href="./logout-adm.php">Logout</a></span>

    <main class="form_account">
        <section class="requests">
            <div class="title-menu">
                <span>Requisições pendentes</span>
            </div>
            <div class="scroll-requests">
                <?php
                    while($reg = mysqli_fetch_assoc($result)){
                        if($reg['status_solicitacao'] == 1 || $reg['status_solicitacao'] == -1 || $reg['status_solicitacao'] == 2){
                            continue;
                        }

                       if(strlen($reg['descricao']) > 100){
                            $desc = substr($reg['descricao'], 0, 97) . '...';
                       }
                       else $desc = $reg['descricao'];
                        echo('
                        <div class="request-item" onclick="changeCurrentRequest('.$reg['id_solicitacao'].', null, null, '.$reg['id_solicitacao'].', \'new_ong\')">
                            <div class="title-rq"><span><u>NOVA ONG:</u> '.$reg['nome'].'</span></div>
                            <div class="info-1">
                                <span id="num-rq">n° Solicitação: '.$reg['id_solicitacao'].'</span>
                                <span id="num-rq" style="margin-left: 10%;">id da ONG: '.$reg['id_ong'].'</span>
                                <span id="date-rq" style="margin-left: 10%;">Data: '.$reg['data_solicitacao'].'</span>
                            </div>
                            <div class="info-2">
                                <span style="font-weight: bold;">Prévia da descrição:</span><br>
                                <span id="themes">'.$desc.'</span>
                            </div>
                        </div>
                        ');
                    }

                    while($reg_mod = mysqli_fetch_assoc($result_mod)){
                        if($reg_mod['status_solicitacao'] == 1 || $reg_mod['status_solicitacao'] == -1 || $reg_mod['status_solicitacao'] == 2){
                            continue;
                        }

                        echo('
                        <div class="request-item modify" onclick="changeCurrentRequest(null, '.$reg_mod['id_solicitacao'].', '.$reg_mod['id_projeto'].', null, \'project_mod\')">
                            <div class="title-rq modify"><span><u>REVISÃO DE PROJETO:</u> '.$reg_mod['nome'].'</span></div>
                            <div class="modify-info">
                                <span id="num-rq">n° Solicitação: '.$reg_mod['id_solicitacao'].'</span>
                                <span id="num-rq" style="margin-left: 10%;">id do projeto: '.$reg_mod['id_projeto'].'</span>
                                <span id="date-rq" style="margin-left: 10%;">Data: '.$reg_mod['data_solicitacao_mudanca'].'</span>
                            </div>
                        </div>
                        ');
                    }
                ?>    
            </div>
        </section>
        <section class="preview">
            <div class="nav-menu">
                <nav class="nav-inner">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab" id="nav0-li"><a class="tab-link" id="nav0"></a></li>
                            <li class="tab" id="nav1-li"><a class="tab-link" id="nav1"></a></li>
                            <li class="tab" id="nav2-li"><a class="tab-link" id="nav2"></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="ong-content">
                <iframe class="iframe" id="iframe" src="wellcome.php" frameborder="0" width="100%" heigth="100%"></iframe>
            </div>
        </section>
    </main>
    <script>
        var el = undefined;
        var navsla = document.querySelector('.tab');
                    
        const navMenu = document.querySelector('.nav-content'),
              iframe = document.getElementById('iframe'),
              navOptions = document.querySelectorAll('.tab-link'),
              nav0 = document.querySelector('#nav0-li'),
              nav1 = document.querySelector('#nav1-li'),
              nav2 = document.querySelector('#nav2-li'),
              allNavOptions = [nav0, nav1, nav2],

              allNewOngNavText = ['Informações Gerais' /*0*/, 'Documentos' /*1*/, 'Ação' /*2*/],
              allNewOngNavSrc = ['general-info.php' /*0*/, 'docs.php' /*1*/, 'action.php' /*2*/],

              allModNavText = ['Informações da ONG'/*0*/, 'Mudanças'/*1*/, 'Ação' /*2*/],
              allModNavSrc = ['ong-info-mod-req.php'/*0*/, 'mod-req-info.php'/*1*/, 'mod-action.php' /*2*/];

              var currentNewOngRequest = undefined, 
                  currentNewOng = undefined, 
				  currentModRequest = undefined,
                  currentProjectModRequest = undefined;

        function changeCurrentRequest(newOngReqId, modReqId, projModId, newOng, reqType){
            if(reqType == 'new_ong'){
                //CHANGE NAV ITEMS TEXT AND IFRAME HREF
                allNavOptions.forEach((NavOption, index, array)=>{
                    let NewNavHtmlString = `<li class="tab"><a class="tab-link" onclick="changeIframe(\'${allNewOngNavSrc[index]}\', this)" id="nav${(index)}">${allNewOngNavText[index]}</a></li>`;
                    let NewNavNode = new DOMParser().parseFromString(NewNavHtmlString, "text/html").querySelector('.tab');

                    $('ul.tabs')[0].insertBefore(NewNavNode, NavOption);
                    
                    NavOption.remove();
                    array[index] = NewNavNode;
                })

                //SWITCH IFRAME SRC
                currentNewOngRequest = parseInt(newOngReqId);
                currentNewOng = parseInt(newOng);
                changeIframe(`./general-info.php`, $('#nav0')[0]);
            }

            if(reqType == 'project_mod'){
                //CHANGE NAV ITEMS TEXT AND IFRAME HREF
                allNavOptions.forEach((NavOption, index, array) =>{
                    let NewNavHtmlString = `<li class="tab"><a class="tab-link" onclick="changeIframe(\'${allModNavSrc[index]}\', this)" id="nav${(index)}">${allModNavText[index]}</a></li>`;
                    let NewNavNode = new DOMParser().parseFromString(NewNavHtmlString, "text/html").querySelector('.tab');
                    $('ul.tabs')[0].insertBefore(NewNavNode, NavOption);
                    
                    NavOption.remove();
                    array[index] = NewNavNode;
                })

                //SWITCH IFRAME SRC
                currentModRequest = parseInt(modReqId);
                currentProjectModRequest = parseInt(projModId);
                changeIframe(`./ong-info-mod-req.php`, $('#nav0')[0]);
            }

        }

        function changeIframe(url, selectedItem){
            if(typeof currentNewOngRequest == 'undefined' && typeof currentModRequest == 'undefined') return false;

            //Change Iframe URL
            /*if the currently selected request is a new ong request*/
            if(typeof currentNewOngRequest != 'undefined'){
                iframe.src = `${url}?req=${currentNewOngRequest}&ong=${currentNewOng}`;
                currentModRequest = undefined;
            }   
            /*if the currently selected request is a mod request*/
            if(typeof currentModRequest != 'undefined'){
                iframe.src = `${url}?req=${currentModRequest}&p=${currentProjectModRequest}`;
                currentNewOngRequest = undefined;
                currentNewOng = undefined;
            }

            //Turn the selected option "active"
            var tabs = navMenu.querySelectorAll('.tab-link');
           
            for(let tab of tabs){
                if(tab.classList.contains('active')){
                    tab.classList.remove('active');
                }
            }

            selectedItem.classList.add('active');
        }
    </script>
</body>
</html>