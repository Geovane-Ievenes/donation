<?php
session_start();
include('./connection.php');

if(isset($_POST['editar'])){

    $id_projeto = $_POST['id_projeto'];

    $valores_antigos_json = $_POST['valores-antigos'];
    $valores_antigos_arr = json_decode($valores_antigos_json, true);
    $valores_novos_json = $_POST['valores-novos'];
    $valores_novos_arr = json_decode($valores_novos_json, true);
    $img_novas = $_POST['img_novas']; //Nome dos inputs
    $img_velhas = $_POST['img_velhas'];
    $img_removidas_json = $_POST['img_removidas'];
    
    $perfil_foi_trocado = ($_POST['perfil_foi_trocado'] == 'true') ? true : false;
    $perfil_foi_removido = ($_POST['perfil_foi_removido'] == 'true') ? true : false;
    $slider_foi_modificado = ($_POST['slider-foi-modificado'] == 'true') ? true : false; 
    $slider_foi_adicionado = ($_POST['slider-foi-adicionado'] == 'true') ? true : false; 
    $slider_foi_apagado = ($_POST['slider-foi-apagado'] == 'true') ? true : false;
    $qtd_sliders_add = intval($_POST['qtd_sliders_add']);

    $id_projeto = $_POST['id_projeto'];

    $solicitar_mod = ($_POST['solicitar_modificacao'] == 'true') ? true : false;
    $salvar = ($_POST['salvar'] == 'true') ? true : false;

    $campos_modificados = [];
    foreach($valores_novos_arr as $campo_mod => $valor){
        array_push($campos_modificados, $campo_mod);
    }
    $campos_modificados_json = json_encode($campos_modificados);

    if($solicitar_mod){ //USUÁRIO EDITOU SLIDERS, NOME OU DESCRIÇÃO DO PROJETO
        $dir_imagens = 'solicitacoes_mod/';

        //ANALISAR MODIFICAÇÕES SOLICITADAS PELO USUÁRIO NOS SLIDERS
        /*Sliders*/ 
        if($slider_foi_modificado){
            if($slider_foi_adicionado){
                $img_novas_campos_arr = json_decode($img_novas, true);
                $novos_slides_nomes_arr = [];
                $i = 0;

                foreach($img_novas_campos_arr as $campo){
                    $slide_atual = $_FILES[$campo];
        
                    $tmp = explode('.', $slide_atual["name"]);
                    $ext = end($tmp);
        
                    $nome_base_novo_slide = md5(uniqid(time())); //O nome é o mesmo, mas cada arquivo terá um sufixo para identificar qual é o slide
                    $nome_arq_novo_slide = $nome_base_novo_slide . 's' . $i++ . '.' . $ext;
                    $caminho_arq_novo_slide = $dir_imagens . $nome_arq_novo_slide;
            
                    if(!move_uploaded_file($slide_atual["tmp_name"], $caminho_arq_novo_slide)){
                        die('Erro ao fazer upload dos novos sliders: ' . mysqli_error($connection));
                    }

                    array_push($novos_slides_nomes_arr, $nome_arq_novo_slide);
                }
                $novos_slides_nomes_json = json_encode($novos_slides_nomes_arr);
            }
            else{
                $novos_slides_nomes_json = '[]';
                $img_velhas = '[]';
            } 

            if($slider_foi_apagado){
                $img_removidas_arr = json_decode($img_removidas_json, true);

                foreach($img_removidas_arr as $img_rm){
                    if(!copy('./fotos_projeto/'.$img_rm, './solicitacoes_mod/'.$img_rm)){
                        die('Erro ao copiar imagens apagadas para pasta: ' . mysqli_error($connection));
                    }
                }
            }

            //Salvar imagens antigas que não foram modificadas
            $img_velhas_json = json_decode($img_velhas, true);
            foreach($img_velhas_json as $img_velha){
                if(!copy('./fotos_projeto/'.$img_velha, './solicitacoes_mod/'.$img_velha)){
                    die('Erro ao copiar fotos para um novo diretório');
                };
            }
        }
        else{
            $img_removidas = '[]';
            $img_velhas = '[]';
            $novos_slides_nomes_json = '[]';
        }

        //Discensão entre variáveis que podem ser vazias e não devem ser inseridas
        $sql_nova_sol = "INSERT INTO tbsolicitacao_mudanca (id_projeto_solicitacao, campos_modificados, valores_antigos, valores_novos, data_solicitacao, ong_solicitacao, projeto_solicitacao, imagens_novas, imagens_apagadas, imagens_existentes, status_solicitacao) VALUES (".$id_projeto.", '".$campos_modificados_json."', '".$valores_antigos_json."', '".$valores_novos_json."', CURRENT_DATE(), '".$_SESSION['cod_perfil_ong']."', ".$id_projeto.", '".$novos_slides_nomes_json."', '".$img_removidas_json."', '".$img_velhas."', 0)";
        $result_sol = mysqli_query($connection, $sql_nova_sol);
        if(!$result_sol){
            die('Erro ao criar solicitação para modificar informações do projeto: ' . mysqli_error($connection));
        }

        echo('<script>alert("Uma solicitação para a modificação de de informações cruciais do projeto foi enviada")</script>');
    }
    
    if($salvar){ //CASO O USUÁRIO MUDA A META DO PROJETO, QUE NÃO PRECISA DE UMA SOLICITAÇÃO

        //MUDAR IMAGEM DO PROJETO
        $dir_foto_perfil = 'fotos_projeto/';

        $query_s_ft_antiga = 'SELECT logo_projeto FROM tbprojeto WHERE id_projeto = '. $id_projeto;
        $result_ft_p = mysqli_query($connection, $query_s_ft_antiga);
        if(!$result_ft_p) die('Erro ao buscar logo atual do projeto');

        $logo_atual = mysqli_fetch_assoc($result_ft_p)['logo_projeto'];

        if($perfil_foi_removido){

            $nome_base_f_apagada = md5(uniqid(time())); 
            $nome_arq_f_apagada = $nome_base_f_apagada . '.png';
            $caminho_arq_f_apagada = $dir_foto_perfil . $nome_arq_f_apagada;

            if(!copy('./no-img.png', $dir_foto_perfil .  $nome_arq_f_apagada)){
                die('Erro ao apagar imagem de perfil');
            }
            else{
                unlink('fotos_projeto/'.$logo_atual);
            }

            $nome_img_perfil = $nome_arq_f_apagada;

            $sql_upd_logo_status = 'UPDATE tbprojeto SET possui_logo = -1 WHERE id_projeto = '.$id_projeto;
            $result_upd_logo_status = mysqli_query($connection, $sql_upd_logo_status);
            if(!$result_upd_logo_status) die('Erro ao apagar imagem de perfil: Status não atualizadopara -1');
        }
        elseif($perfil_foi_trocado){
            $perfil = $_FILES['logo_projeto'];

            $tmp = explode('.', $perfil["name"]);
            $ext = end($tmp);

            $nome_base_perfil = md5(uniqid(time())); //O nome é o mesmo, mas cada arquivo terá um sufixo para identificar qual é o slide
            $nome_arq_perfil = $nome_base_perfil . 'P' . '.' . $ext;
            $caminho_arq_perfil = $dir_foto_perfil . $nome_arq_perfil;
    
            if(!move_uploaded_file($perfil["tmp_name"], $caminho_arq_perfil)){
                die('Erro ao atualizar imagem de perfil');
            }
            else{
                unlink('fotos_projeto/'.$logo_atual);
            }

            $nome_img_perfil = $nome_arq_perfil;

            $sql_upd_logo_status = 'UPDATE tbprojeto SET possui_logo = 1 WHERE id_projeto = '.$id_projeto;
            $result_upd_logo_status = mysqli_query($connection, $sql_upd_logo_status);
            if(!$result_upd_logo_status) die('Erro ao apagar imagem de perfil: Status não atualizado para 1');
        }   
        else{
            $nome_img_perfil = null;
        }

        if($nome_img_perfil !== null){
            $sql_upd_profile = 'UPDATE tbprojeto SET logo_projeto = "'.$nome_img_perfil.'" WHERE id_projeto = '. $id_projeto;
            $result_upd_logo = mysqli_query($connection, $sql_upd_profile);
            if(!$result_upd_logo) die('Erro ao atualizar foto de perfil do usuário: ' . mysqli_error($connection));
        }

        if(in_array('meta_projeto', $campos_modificados)){
            $sql_ins = 'UPDATE tbprojeto SET ';
            $campos_alterados = array_keys($valores_novos_arr);
            $valores_alterados = array_values($valores_novos_arr);
            $i = 0;
            foreach($campos_alterados as $campo){
                $sql_ins .= $campo .' = '. $valores_alterados[$i];
                if($i + 1 != (sizeof($campos_alterados))) $sql_ins .= ', ';
                $i++;
            }
            $sql_ins .= ' WHERE id_projeto = '. $id_projeto;

            $result = mysqli_query($connection, $sql_ins);
            if(!$result){
                die('Erro ao atualizar dados do projeto, Erro: ' . mysqli_error($connection));
            }
        }

        echo('<script>alert("Informações salvas com sucesso !!")</script>');
    }

    echo('<script>location.href = "gerenciamento.php"</script>');
}

?>