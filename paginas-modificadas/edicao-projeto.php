<?php
    session_start();
    include('./connection.php');
    if(isset($_GET['p']) && isset($_SESSION['cod_perfil_ong'])){
        $project = $_GET['p'];
        $sol_pendente = 'false';

        $select_verify_q = 'SELECT * FROM tbprojeto WHERE id_projeto = '. $project.' AND id_ong_projeto = '.$_SESSION['cod_perfil_ong'];
        $result = mysqli_query($connection, $select_verify_q);
        if(!$result){ // $result == false, mal sucedido (EOO AO BUSCAR PROJETO)
            die('Erro ao identificar permissões de usuário');
        }

        $n_reg = mysqli_num_rows($result);  

        if($n_reg == 0){ // $result == true, mas não traz nenhum registro (NENHUM ENCONTRADO, ou não existe, ou a ong logada não é dona do projeto)
            header('location: gerenciamento.php');
        }else{ // $result == mysqli_result, bem sucedido, traz registros verídicos (PROJETO ENCONTRADO)
            $reg = mysqli_fetch_assoc($result);

            $select_sol_anterior = 'SELECT * FROM tbsolicitacao_mudanca WHERE id_projeto_solicitacao = '.$project.' AND ong_solicitacao = '.$_SESSION['cod_perfil_ong'] . ' ORDER BY id_solicitacao_mudanca DESC limit 1';
            $result_sol_anterior = mysqli_query($connection, $select_sol_anterior);
            if(!$result_sol_anterior) die('Erro ao verificar se projeto já possui solicitação de mudança pendente');

            if($reg_sol_anterior = mysqli_fetch_assoc($result_sol_anterior)){ //Se existe uma solicitação de mudaça pendente
                if($reg_sol_anterior['status_solicitacao'] == 0){
                    $sol_pendente = 'true';
                    echo('<script>alert("Você já solicitou uma revisão no seu projeto, aguarde enquanto nossa equipe trabalha nisso");</script>');
                }

                if($reg_sol_anterior['status_solicitacao'] == -1){
                    $sql_msg_erro = 'SELECT erro_msg FROM tbsolicitacao_mudanca WHERE id_solicitacao_mudanca = '.$reg_sol_anterior['id_solicitacao_mudanca'];   
                    $result_msg_erro = mysqli_query($connection, $sql_msg_erro);
                    if(!$result_msg_erro) die('Erro ao buscar justificativa para reprovação da solicitação: ' . mysqli_error($connection));
                    
                    $msg_erro = mysqli_fetch_assoc($result_msg_erro)['erro_msg'];
                    echo('<script>alert("Sua solicitação foi rejeitada devido ao seguinte motivo: '.$msg_erro.'. Se você acha que ocorreu algum engano desse processo, por favor entre em contato em do.nation@gmail.com");</script>');

                    //O status de solicitação 2 significa que a mensagem de erro já foi vizualizada e o usuário está ciente da rejeição
                    $sql_upd_status_sol = 'UPDATE tbsolicitacao_mudanca SET status_solicitacao = 2 WHERE id_solicitacao_mudanca = '.$reg_sol_anterior['id_solicitacao_mudanca'];
                    $result_upd_status_sol = mysqli_query($connection, $sql_upd_status_sol);
                    if(!$result_upd_status_sol) die('Erro ao atualizar status da solicitação: ' . mysqli_error($connection));
                }
            } 
        }
    }else{
        header('location: gerenciamento.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projeto</title>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        
        <link rel="stylesheet" type="text/css" href="./edicao-projeto.css">
        <link rel="stylesheet" href="./slider/slider.css">

        <link rel="stylesheet" href="./include/header.css">
        <link rel="stylesheet" href="./include/footer.css">
        <link rel="stylesheet" href="./css/menu.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body>

    <?php
        include("./include/header.php");
    ?>
<main>
    <form action="modify-project.php" method="POST" id="form-atualizar-dados" enctype="multipart/form-data">
        <input type="hidden" name="valores-antigos" id="valores-antigos">
        <input type="hidden" name="valores-novos" id="valores-novos">
        <input type="hidden" name="slider-foi-modificado" id="slider-mod" value="false">
        <input type="hidden" name="slider-foi-adicionado" id="slider-add" value="false">
        <input type="hidden" name="slider-foi-apagado" id="slider-rmv" value="false">
        <input type="hidden" name="qtd_sliders_add" id="qtd_sliders_add" value="false">
        <input type="hidden" name="img_novas" id="img_novas">
        <input type="hidden" name="img_velhas" id="img_velhas">
        <input type="hidden" name="img_removidas" id="img_removidas">
        <input type="hidden" name="perfil_foi_trocado" id="perfil_foi_trocado" value="false">
        <input type="hidden" name="perfil_foi_removido" id="perfil_foi_removido" value="false">

        <input type="hidden" name="solicitar_modificacao" id="solicitar_mod" value="false">
        <input type="hidden" name="salvar" id="salvar" value="false">
        <input type="hidden" name="id_projeto" value="<?php echo($project);?>">

        <div class="wrapper">
            <div class="wrapper_preview">
                <div class="preview">
                    <input type="file" name="logo_projeto" class="logo_projeto" accept="image/png,image/jpeg,image/jpg" id="profile-pic" onchange="validateProfilePic(this, true /*edit project page*/)">
                    <span class="error-message" id="profile"></span>
                    <img src="./fotos_projeto/<?php echo($reg['logo_projeto']);?>" alt="Foto perfil" id="profile-img" style="border-radius: 50%;">
                    <button name="remove-image" id="remove-image" type="button" onclick="removeProfilePic(true /*edit project page*/)" <?php if($reg['possui_logo'] == -1) echo('style="display: none;"');?>>Remover</button>
                </div>
                
                <div class="edit-slider">
                    <?php include('./slider/slider-edit-proj.php');?>
                </div>
                <script src="./slider/slider-edit.js"></script>
            </div>
            <div class="wrapper_infos">
                <div class="div_infos">
                    <h3 class="title"><?php echo($reg['nome_projeto']);?></h3>

                    <span class="nome">Editar nome do projeto</span>
                    <input type="text" id="nome" value="<?php echo($reg['nome_projeto']);?>" class="input need-verify input-required" onkeyup="checkNewValue(this.value, this.id)">  
                    <span class="error-message" id="0"></span>

                    <span class="meta">Editar meta do projeto</span>
                    <input type="text" id="meta" value="<?php echo($reg['meta_projeto']);?>" class="input input-required" onkeyup="checkNewValue(this.value, this.id)" maxlength="9">  
                    <span class="error-message" id="1"></span>
                    <script>
                        function formatCurrency() {
                            var input = document.getElementById('meta');
                            var value = input.value;
                                    
                            value = value + '';
                            value = parseInt(value.replace(/[\D]+/g, ''));
                            value = value + '';
                            value = value.replace(/([0-9]{2})$/g, ".$1");

                            if (value.length > 5) {
                                value = value.replace(/([0-9]{3}).([0-9]{2}$)/g, "$1.$2");
                            }

                            input.value = value;
                            if(value == 'NaN') input.value = '';
                        }
                    </script>

                    <span class="txt">Editar descrição do projeto</span>
                    <input type="hidden" name="inputs[descricao_projeto][status]" value="false" id="desc-status">
                    <textarea name="inputs[descricao_projeto][status]" id="desc" class="input need-verify" onkeyup="checkNewValue(this.value, this.id)" cols="35" rows="10" placeholder="Descrição do Projeto"><?php echo($reg['descricao_projeto']);?></textarea>

                    <input type="submit" name="editar" value="Solicitar Modificação" id="submit-input" disabled> 
                </div>
            </div>

        </div>

    </form>
    
</main>
    <?php
        include("./include/footer.php");
    ?>

    <script src="./js/general-validation.js"></script>
    <script src="./js/file-validation.js"></script>
    <script src="./js/profile-preview.js"></script>
    <script>
        const pendingRequest = <?php echo($sol_pendente);?>;

        var imgHasBeenEdited = false;
        var imgAddedFileInputs = [];
        var oldImg = [];

        const ProfilePic = document.querySelector('#profile-pic');
        const RemoveProfile = document.querySelector('#remove-image');

        const oldNome = "<?php echo($reg['nome_projeto']);?>";
        const oldMeta = <?php echo($reg['meta_projeto']);?>;
        const oldDesc = "<?php echo($reg['descricao_projeto']);?>";

        var oldDataMap = new Map();
        var newDataMap = new Map();

        const submitInput = $('#submit-input')[0];
        const form = $('#form-atualizar-dados')[0];
        const submitOldValues = $('#valores-antigos')[0];
        const submitNewValues = $('#valores-novos')[0];
        const submitOldImg = $('#img_velhas')[0];
        const submitNewImgFileInputs = $('#img_novas')[0];
        const submitNewProfilePic = $('#nova_foto_perfil')[0];
        const addedSlidersCount = $('#qtd_sliders_add');
        const submitRemovedSliders = $('#img_removidas')[0];

        const requestStatus = $('#solicitar_mod')[0]; 
        const saveStatus = $('#salvar')[0]; 
        const profileChangedStatus = $('#perfil_foi_trocado')[0];
        const profileRemovedStatus = $('#perfil_foi_removido')[0];

        function checkNewValue(value, inputId){
            switch(inputId){
                case 'nome':    
                    if(value != oldNome){
                        newDataMap.set('nome_projeto', value);
                        oldDataMap.set('nome_projeto', oldNome)
                    } 
                    else{
                        newDataMap.delete('nome_projeto');
                        oldDataMap.delete('nome_projeto');
                    } 
                    break;

                case 'meta':
                    if(value != oldMeta){
                        newDataMap.set('meta_projeto', value);
                        oldDataMap.set('meta_projeto', oldMeta);
                        formatCurrency();
                    } 
                    else {
                        newDataMap.delete('meta_projeto');
                        oldDataMap.delete('meta_projeto');
                    } 
                    break;

                case 'desc':
                    if(value != oldDesc){
                        newDataMap.set('descricao_projeto', value);
                        oldDataMap.set('descricao_projeto', oldDesc)
                    } 
                    else{
                        newDataMap.delete('descricao_projeto');
                        oldDataMap.delete('descricao_projeto');
                    } 
                    break;
            }

            if(oldDataMap.size > 0 && !pendingRequest) submitInput.disabled = false;
            else submitInput.disabled = true;

            // Dados cruciais que, se modificados, precisam de revisão
            if(newDataMap.has('nome_projeto') || newDataMap.has('descricao_projeto')){
                submitInput.value = 'Solicitar Modificação';
                requestStatus.value = 'true';
            }
            else{
                submitInput.value = 'Solicitar Modificação';
            }

            if(newDataMap.has('meta_projeto')){
                saveStatus.value = 'true';
            }
        }

        form.addEventListener('submit', function(e){

            const allSlidesImg = document.querySelectorAll('.mySlides img.image');

            var newDataObj = {};
            var oldDataObj = {};

            for(let item of newDataMap){
                newDataObj[item[0]] = item[1];
            }

            for(let item of oldDataMap){
                oldDataObj[item[0]] = item[1];
            }

            /*Get all added and old slider's image*/ 
            allSlidesImg.forEach(function(img){
                let CurrentSlideId = img.parentNode.id;
                let CurrentSrc = img.src;
                let currentFileInputName = `file${CurrentSlideId}`;

                if(img.src.indexOf('blob:') > -1){
                    imgAddedFileInputs.push(currentFileInputName);
                    SliderAddStatus.value = "true";
                }
                else{
                    oldImgPath = CurrentSrc.split('/');
                    oldImgName = oldImgPath[oldImgPath.length - 1]
                    oldImg.push(oldImgName);
                }
            })

            /*See if user has at least 1 image in the slider*/
            //Quantidade de input files é sempre 1 a mais, então para saber a quantidade de slider, subtrai-se 1 da quantia de inout files
            var slidersCount = ($('.input-file-container')[0].querySelectorAll('input[type=file]').length - 1);
            if(slidersCount == 0){
                alert('Você precisa ter ao menos uma imagem em seu carrosel de imagens');
                e.preventDefault();
                return false; 
            }  

            /*Stringify JSON Content*/ 
            submitNewValues.value = JSON.stringify(newDataObj);
            submitOldValues.value = JSON.stringify(oldDataObj);
            submitOldImg.value = JSON.stringify(oldImg);
            submitNewImgFileInputs.value = JSON.stringify(imgAddedFileInputs);
            SubmitSlidersCount.value = slidersCount;
            addedSlidersCount.value = newSlidersCount;
            submitRemovedSliders.value = (imgRemoved.length == 0) ? '[]' : (JSON.stringify(imgRemoved));

            // e.preventDefault();
        })  
    </script>
</body>
</html>