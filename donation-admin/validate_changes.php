<?php
    session_start();
    header('Content-Type: text/html; charset=utf-8');

    include('./connection.php');
    if(!isset($_POST)) die('Operação inválida');

    $id_req = intval($_POST['id']);
    $err = false;

    //Atualizar status da requisição
    $query_upd_req = 'UPDATE tbsolicitacao_mudanca SET status_solicitacao = 1 WHERE id_solicitacao_mudanca = ' . $id_req;
    $result_upd_req = mysqli_query($connection, $query_upd_req);
    if(!$result_upd_req) $err =  'Erro ao atualizar status da requisição: ' . mysqli_error($connection);

    $query_s = 'SELECT * FROM tbsolicitacao_mudanca WHERE id_solicitacao_mudanca = ' . $id_req;
    $result_s = mysqli_query($connection, $query_s);

    if(!$result_s) $err = mysqli_error($connection);
    else{
        $reg = mysqli_fetch_assoc($result_s);

        //SUBSTITUINDO NOVOS VALORES NA TBPROJETO
        $valores_novos_arr = json_decode($reg['valores_novos'], true);

        //Atualizar campo nome, 
        foreach($valores_novos_arr as $campo => $valor){
            $query_upd_proj = 'UPDATE tbprojeto SET '.$campo.' = "'.$valor.'" WHERE id_projeto = '. $reg['projeto_solicitacao'];
            $result_upd_proj = mysqli_query($connection, $query_upd_proj);
            if(!$result_upd_proj) $err = 'Erro ao atualizar inforações do projeto: ' . mysqli_error($connection);
        }
        
        //GUARDANDO NOVAS IMAGEM E IMAGENS APAGANDAS PARA EXECUTAR AÇÃO DA REQUEST
        $imagens_novas_arr = json_decode($reg['imagens_novas'] ,true);
        $imagens_existentes_arr = json_decode($reg['imagens_existentes'] ,true);
        $imagens_apagadas_arr = json_decode($reg['imagens_apagadas'] ,true);

        //Se imagens foram deletadas do slider, então...
        if(!empty($imagens_apagadas_arr)){
            foreach($imagens_apagadas_arr as $img_Rm){
                $sql_del_img = 'DELETE FROM tbimagens WHERE imagem_projeto = "'. $img_Rm . '"';
                $result_del_img = mysqli_query($connection, $sql_del_img);

                if(!$result_del_img) $err = 'Erro ao apagar imagem: ' . mysqli_error($connection);
                else unlink('../fotos_projeto/'.$img_Rm); //Apaga foto deletada do diretório de fotos
            }
        }

        //Se houver alguma nova imagem adicionada, pegue essas imagem e adicione no banco
        if(!empty($imagens_novas_arr) && !empty($imagens_existentes_arr)){ 
            foreach($imagens_novas_arr as $img_Nova){
                $sql_ins_nova_img = 'INSERT INTO tbimagens (id_projeto_imagem, imagem_projeto, tipo_imagem) VALUES ('.$reg['id_projeto_solicitacao'].', "'.$img_Nova.'",1)';
                $result_ins_nova_img = mysqli_query($connection, $sql_ins_nova_img);

                if(!$result_ins_nova_img) 'Erro ao inserir imagens novas: ' . $err = mysqli_error($connection);
                if(!copy('../solicitacoes_mod/'.$img_Nova, '../fotos_projeto/'.$img_Nova));
            }

            foreach($imagens_novas_arr as $img_nv){
                unlink('../solicitacoes_mod/'.$img_nv);
            }
            foreach($imagens_existentes_arr as $img_ex){
                unlink('../solicitacoes_mod/'.$img_ex);
            }
        }
    }

    if(!$err) echo(json_encode(array('error'=>false)));
    else echo(json_encode(array('error'=>$err)));
?>