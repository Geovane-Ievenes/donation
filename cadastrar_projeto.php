<?php
    session_start();
    include('./connection.php');
    if(isset($_SESSION['nome_usuario'])){
        if(!isset($_SESSION['cod_perfil_ong'])){
            header('location: index.php'); // não é ONG
            exit;
        }

        $sql_cad_ong = 'SELECT * FROM tbcadastro_ong WHERE id_ong_cadastro = ' . $_SESSION['cod_perfil_ong'];
        $result_cad_ong = mysqli_query($connection, $sql_cad_ong);

        if(!$result_cad_ong) die(mysqli_error($connection));

        $sql_req = 'SELECT situacao_tentativa FROM tbtentativa_cadastro WHERE id_ong_tentativa = ' . $_SESSION['cod_perfil_ong'] . ' ORDER BY id_tentativa DESC limit 1';
        $result_req = mysqli_query($connection, $sql_req);

        if(!$result_req) die(mysqli_error($connection));

        $req = mysqli_fetch_assoc($result_req);

        if($req['situacao_tentativa'] == -1){
            echo('<script>window.alert("Infelizmente sua solicitação de cadastro como ONG foi RECUSADA. Caso acredite que ocorreu um erro na validação de suas informações, entre em contato no e-mail: do.nation@gmail.com")</script>');
            echo('<script>window.location = "index.php"</script>');
        }   
        elseif(!mysqli_num_rows($result_cad_ong) > 0){
            echo('<script>window.alert("Você ainda não tem permissão para criar ou editar projetos. O processo de aprovação de uma ONG leva em torno de duas semanas para ser concluído.")</script>');
            echo('<script>window.location = "index.php"</script>');
        }  

    }   
    else{
        header('location: logout.php');
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Projetos - Do.Nation</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./css/menu.css">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>-->

    <!--poppper.js-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <link rel="stylesheet" href="cadastrar_projetos.css">
    <link rel="stylesheet" href="./slider/slider.css">

    <link rel="stylesheet" href="./include/header.css">
    <link rel="stylesheet" href="./include/footer.css">
    <script src="./js/header-animation.js"></script>
    <style>
        #profile-img{
            width: 100px;
            height: 100px;
        }

        #remove-image{
            display: none;
            margin-top: 10px;
        }

        #profile-label{
            width: 150px;
            height: 150px;
            background-image: url('./no-profile.jpg');
            position: absolute;
            top: 170px;
            left: 500px;
            border-radius: 50%;
            background-position: center;
            background-repeat: no-repeat;
        }

        #profile-label:hover{
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
        include("./include/header.php");
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <main>
        <div class="container_form">
            <form action="new-project.php" method="POST" enctype="multipart/form-data" id="form-cad-projeto">
                <div class="wrapper">
                    <label for="profile-pic" id="profile-label"></label>

                    <input type="file" name="logo_projeto" class="logo_projeto" accept="image/png,image/jpeg,image/jpg" id="profile-pic" onchange="validateProfilePic(this)" style="display: none;">
         
                    <span class="error-message" id="profile"></span>

                    <div class="preview" style="display: none;">
                        <img src="" alt="Foto perfil" id="profile-img" style="border-radius: 50%;"> 
                    </div>  

                    <button id="remove-image" type="button" onclick="removeProfilePic()" style="display: none;">Remover</button>
                </div>
                <div class="onright">
                    <div>
                        <input type="text" name="nome_projeto" class="nome_projeto input-required" placeholder="Nome do Projeto">
                        <span class="error-message" id="0"></span>
                    </div>
                    <div> 
                        <strong>R$ </strong><input type="text" name="meta_projeto" id="meta-dinheiro" class="meta_projeto input-required" placeholder="Meta do Projeto" onkeyup="formatCurrency()" maxlength="10">
                        <span class="error-message" id="1"></span>
                        <script>
                                function formatCurrency() {
                                    var input = document.getElementById('meta-dinheiro');
                                    var value = input.value;
                                    

                                    value = value + '';
                                    value = parseInt(value.replace(/[\D]+/g, ''));
                                    value = value + '';
                                    value = value.replace(/([0-9]{2})$/g, ",$1");

                                    if (value.length > 6) {
                                        value = value.replace(/([0-9]{3}).([0-9]{2}$)/g, ".$1,$2");
                                    }

                                    input.value = value;
                                    if(value == 'NaN') input.value = '';
                                }
                        </script>
                    </div>
                    <div>
                        <textarea name="descricao_projeto" class="descricao_projeto input-required" cols="50" rows="8" maxlength="280" minlength="3" placeholder="Descrição do Projeto"></textarea>
                        <span class="error-message" id="2"></span>
                    </div>
                </div>
                <script type="text/javascript">
                    var globalCheked = 0;

                    (function(){
                        "use strict";
    
                        var marcados = 0;
                        var verifyCheckeds = function($checks) {
                            if( marcados>=3 ) {
                                loop($checks, function($element) {
                                    $element.disabled = $element.checked ? '' : 'disabled';
                                });
                            } else {
                                loop($checks, function($element) {
                                    $element.disabled = '';
                                });
                            }
                        };
                        var loop = function($elements, cb) {
                            var max = $elements.length;
                            while(max--) {
                                cb($elements[max]);
                            }
                        }
                        var count = function($element) {
                            if($element.checked) globalCheked++;
                            else globalCheked--;

                            return $element.checked ? marcados + 1 : marcados - 1;
                        }
                        window.onload = function(){
                            var $checks = document.querySelectorAll('input.checkbox-goal');
                            loop($checks, function($element) {
                                $element.onclick = function(){
                                    marcados = count(this);
                                    $('.error-message#goals').html('');
                                    verifyCheckeds($checks);
                                }
                                if($element.checked) marcados = marcados + 1;
                            });
                            verifyCheckeds($checks);
                        }
                    }());  
                </script>
                <div class="section_options">
                    <label>Escolha as áreas de atuação de seu projeto:</label>
                    <input type="hidden" name="chosed-goals" id="chosed-goals">
                    <input type="hidden" name="chosed-ODS" id="chosed-ODS">

                    <div>
                        <span class="error-message" id="goals"></span> <!--IF USER DON'T CHOSE A GOLA...-->
                        <label class="container">
                            <div class="ods-label" id="2" style="color: #dda73a;">
                                <h3>Fome Zero e Agricultura Sustentável</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="2a" onchange="switchGoal(this)">
                                    <span class="#">Incentivo a práticas agrícolas</span>
                                </label>

                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="2b" onchange="switchGoal(this)">
                                    <span class="#">Distribuição de alimentos</span>
                                </label>
                            </div><br>
                            <div class="ods-label" id="3" style="color: #4ca146;">
                                <h3>Saúde e Bem-Estar</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="3a" onchange="switchGoal(this)">
                                    <span class="#">Acomodação de pessoas enfermas</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="3b" onchange="switchGoal(this)">
                                    <span class="#">Tratamento de pessoas doentes</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="3c" onchange="switchGoal(this)">
                                    <span class="#">Arrecadação de utensílios médicos</span>
                                </label>
                            </div><br>
                            <div class="ods-label" id="4" style="color: #c7212f;">
                                <h3>Educação de Qualidade</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="4a" onchange="switchGoal(this)">
                                    <span class="#">Garantir o acesso à informação</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="4b" onchange="switchGoal(this)">
                                    <span class="#">Oficinas para jovens e crianças</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="4c" onchange="switchGoal(this)">
                                    <span class="#">Equipamentos e materiais didáticos</span>
                                </label>      
                            </div><br>
                            <div class="ods-label" id="5" style="color: #ef402d;">
                                <h3>Igualdade de Gênero</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="5a" onchange="switchGoal(this)">
                                    <span class="#">Protagonismo feminino na sociedade</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="5b" onchange="switchGoal(this)">
                                    <span class="#">Combate à violência contra a mulher </span>
                                </label>
                            </div><br>
                            <div class="ods-label" id="6" style="color: #27bfe6;">
                                <h3>Água Potável e Saneamento</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="6a" onchange="switchGoal(this)">
                                    <span class="#">Descarte adequado do lixo</span>
                                </label>
                            </div><br>
                            <div class="ods-label" id="7" style="color: #fbc412;">
                                <h3>Energia Acessível e Limpa</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="7a" onchange="switchGoal(this)">
                                    <span class="#">Incentivo à energia limpa</span>
                                </label> 
                            </div><br>
                            <div class="ods-label" id="8" style="color: #a31c44;">
                                <h3>Trabalho Decente e Crescimento Econômico</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="8a" onchange="switchGoal(this)">
                                    <span class="#">Jovem no mercado de trabalho</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="8b" onchange="switchGoal(this)">
                                    <span class="#">Projeto de vida</span>
                                </label>   
                            </div><br>
                            <div class="ods-label" id="10" style="color: #de1768;">
                                <h3>Redução da Desigualdades</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="10a" onchange="switchGoal(this)">
                                    <span class="#">Tornar acessível a informação</span>
                                </label>
                            </div><br>
                            <div class="ods-label" id="11" style="color: #f89d2a;">
                                <h3>Cidades e Comunidades Sustentáveis</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="11a" onchange="switchGoal(this)">
                                    <span class="#">Preservação dos espaços públicos</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="11b" onchange="switchGoal(this)">
                                    <span class="#">Patrimônios naturais e culturais</span>
                                </label>
                            </div><br>
                            <div class="ods-label" id="12" style="color: #bf8d2c;">
                                <h3>Consumo e Produção Responsáveis</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="12a" onchange="switchGoal(this)">
                                    <span class="#">Ajuda no padrão de consumo das pessoas</span>
                                </label>       
                            </div><br>
                            <div class="ods-label" id="13" style="color: #407f46;">
                                <h3>Ação Contra a Mudança Global do Clima</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="13a" onchange="switchGoal(this)">
                                    <span class="#">Conscientizar sobre o efeito estufa</span>
                                </label>
                            </div><br>
                            <div class="ods-label" id="14" style="color: #1f97d4;">
                                <h3>Vida na Água</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="14a" onchange="switchGoal(this)">
                                    <span class="#">Preservação de ecossistemas marinhos</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="14b" onchange="switchGoal(this)">
                                    <span class="#">Conhecer sobre a vida marinha</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="14c" onchange="switchGoal(this)">
                                    <span class="#">Reciclagem</span>
                                </label>
                            </div><br>
                            <div class="ods-label" id="15" style="color: #59ba47;">
                                <h3>Vida Terrestre</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="15a" onchange="switchGoal(this)">
                                    <span class="#">Preservação de ecossistemas terrestres</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="15b" onchange="switchGoal(this)">
                                    <span class="#">Conhecer sobre a vida terrestre</span>
                                </label>
                            </div><br>
                            <div class="ods-label" id="16" style="color: #136a9f;">
                                <h3>Paz, Justiça e Instituições Eficazes</h3>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="16a" onchange="switchGoal(this)">
                                    <span class="#">Auxílio a refugiados</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="16b" onchange="switchGoal(this)">
                                    <span class="#">Combater a exploração sexual</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="checkbox-goal" name="16c" onchange="switchGoal(this)">
                                    <span class="#">Menores em áreas de violência</span>
                                </label>
                            </div>
                    </label>
                </div>
                <div>
                    <span>Insira imagens sobre o seu projeto:</span>
                </div>

                <span class="error-message" id="slider"></span>

                <?php 
                    include('./slider/slider-cad-proj.php');
                ?>
                <script src="./slider/slider-cad.js"></script>

                <div class="contato">
                    <h2>Divulgação e Contato</h2>

                    <div class="input_form">
                        <input type="email" name="email_projeto" class="email_projeto" placeholder="Insera o email da organização" size="45">
                    </div>
                    <div class="input_form">
                        <label for="url_facebook"> Insira um link para o Facebook do projeto: </label>
                        <input type="url" name="facebook_projeto" class="instagram_projeto" id="url_facebook"
                        placeholder="https://www.facebook.com"
                        pattern="https://.*" size="30" required>
                    </div>
                    <div class="input_form">
                        <label for="url_instagram"> Insira um link para o Instagram do projeto: </label>
                        <input type="url" name="instagram_projeto" class="instagram_projeto" id="url_instagram"
                        placeholder="https://www.instagram.com"
                        pattern="https://.*" size="30" required>
                    </div>
                    <div class="input_form">
                        <label for="url_twitter"> Insira um link para o Twitter do projeto: </label>
                        <input type="url" name="twitter_projeto" class="twitter_projeto" id="url_twitter"
                        placeholder="https://www.twitter.com"
                        pattern="https://.*" size="30" required>
                    </div>      
                </div>
                <div class="assinatura">
                    <p class="price">Preço da assinatura: R$12,00 (equivalente a apenas R$1,00 mensal 1 !!)</p><br>
                    <section class="pix">
                        <div class="pix-end">
                            Chave Pix: do.nation@gmail.com
                        </div>
                    </section>
                    <section class="proof">
                        <input type="file" name="comprovante" value="comprovante" class="comprovante" id="comprovante" accept="image/png,image/jpeg,image/jpg" style="display: none"> 
                        <label for="comprovante" class="input-comprovante">Insira o Comprovante de Doação</label><br>
                        <div id="file-name-space" style="margin-left: 20px;">
                            <p class="file-name"></p>
                        </div>
                    </section>
                </div>
                <br><div class="input_form">
                    <label class="container-checkbox">
                        <input type="checkbox" id="aceito-termos" onchange="acceptProjectTerms(this)">Eu li e aceito os <a href="#">Termos de Uso Sobre Criação de Projetos</a>
                        <span class="checkmark"></span><br>
                        <span class="error-message" id="terms"></span>
                    </label>
                </div> 

                <div class="input_form">
                    <input type="submit" name="criar" class="btn btn-primary" onsubmit="setAllGoals()" id="submit" value="Criar Projeto">
                </div>
            </form> 
        </div>
    </main>
    <?php
        include("./include/footer.php");
    ?>
    <script src="./js/general-validation.js"></script>
    <script src="./js/proj-cad-validation.js"></script>
    <script src="./js/file-validation.js"></script>
    <script src="./js/profile-preview.js"></script>
    <script>    
        FileStatus.push('empty'); // First image is undefined, so, it's empty

        const FormCadProjeto = document.querySelector('#form-cad-projeto'),
              RemoveProfile = document.querySelector('#remove-image'),
              SubmitGoals = document.querySelector('#chosed-goals'),
              SubmitODS = document.querySelector('#chosed-ODS');

        var ProfilePic = document.querySelector('#profile-pic');
        
        var chosedGoals = [];
        var chosedODS = [];

        ProfilePic.addEventListener('change', ()=>{
            HasProfilePicture = true;
        })

        //SAVE ON JAVASCRIPT ALL ODS AND GOALS CHODES BY USER
        function switchGoal(checkbox){
            var odsLabel = checkbox.parentNode.parentNode;

            if(checkbox.checked){ //checkbox checked
                chosedGoals.push(checkbox.getAttribute("name"));  
                chosedODS.push(odsLabel.id)
            }
            else{
                let goalIndex = chosedGoals.indexOf(checkbox.getAttribute("name"));
                let odsIndex = chosedODS.indexOf(odsLabel.id);

                chosedGoals.splice(goalIndex, 1);
                chosedODS.splice(odsIndex, 1);
            }
        }

        //ACCEPT PROJECT TERMS
        function acceptProjectTerms(checkbox){
            if(checkbox.checked){
                projectTermsAccept = true;
                $('.error-message#terms').html('');
            }
            else projectTermsAccept = false;
        }

        //VALIDATE FORM AND SEND INFORMATION
        FormCadProjeto.addEventListener('submit', (e)=>{
            SubmitGoals.value = JSON.stringify(chosedGoals);
            SubmitODS.value = JSON.stringify(chosedODS);
            SubmitSlidersCount.value = slidersCount;

            validateProjectForm(e);
        })

        //VALIDAR ENVIO DO COMPROVANTE
        const fileName = document.querySelector('.file-name');
        const comprovante =  document.querySelector('#comprovante');

        var validProof = undefined;
        var proofHasBeenInserted = false;

        function showName(FileInput){
            if(typeof FileInput.files[0] !== 'undefined'){
                fileName.innerText = FileInput.files[0].name;
            }
            else fileName.innerText = '';
        }

        comprovante.addEventListener('change', (e)=>{
            let valid = validarArquivo(comprovante, null, 'image', 'proofPopup');
            if(valid){
                validProof = true;
                showName(comprovante);
            }
            else fileName.innerText = '';
        })

    </script>
</body>
</html> 