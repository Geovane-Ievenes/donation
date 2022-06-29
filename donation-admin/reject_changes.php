<?php
    session_start();
    header('Content-Type: text/html; charset=utf-8');

    include('./connection.php');
    if(!isset($_POST)) die('Operação inválida');

    $id_req = intval($_POST['id']);
    $rej_msg = $_POST['rej_msg'];

    $query_upd = 'UPDATE tbsolicitacao_mudanca SET status_solicitacao = -1, erro_msg = "'.$rej_msg.'" WHERE id_solicitacao_mudanca = ' . $id_req;
    $result_upd = mysqli_query($connection, $query_upd);

    if(!$result_upd) $err = mysqli_error($connection);

    $query_s = 'SELECT * FROM tbsolicitacao_mudanca WHERE id_solicitacao_mudanca = ' . $id_req;
    $result_s = mysqli_query($connection, $query_s);

    if(!$result_s) $err = mysqli_error($connection);
    else{
        $reg = mysqli_fetch_assoc($result_s);
        
        $imagens_novas_arr = json_decode($reg['imagens_novas'] ,true);
        $imagens_existentes_arr = json_decode($reg['imagens_existentes'] ,true);

        foreach($imagens_novas_arr as $img_nv){
            unlink('../solicitacoes_mod/'.$img_nv);
        }
        foreach($imagens_existentes_arr as $img_ex){
            unlink('../solicitacoes_mod/'.$img_ex);
        }
    }

    if($result_upd) echo(json_encode(array('error'=>false)));
    else echo(json_encode(array('error'=>$err)));
?>