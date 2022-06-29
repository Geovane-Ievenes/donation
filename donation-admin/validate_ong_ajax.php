<?php
    session_start();
    header('Content-Type: application/json; charset=utf-8');

    include('./connection.php');
    if(!isset($_POST)) die('Operação inválida');

    $id_req = $_POST['id'];
    $id_ong = $_POST['ong'];

    $query_ins = 'INSERT INTO tbcadastro_ong (id_cadastro_ong, id_ong_cadastro, data_cadastro_ong, id_tentativa_cadastro, id_adm_verificacao_ong) VALUES (NULL,'.$id_ong.', CURRENT_DATE(),'.$id_req.','.$_SESSION['id_adm'].');';

    $result = mysqli_query($connection, $query_ins);

    if(!$result) $err = mysqli_error($connection);
    else{
        $query_upd = 'UPDATE tbtentativa_cadastro SET situacao_tentativa = 1 WHERE id_tentativa = ' . $id_req;
        $result_upd = mysqli_query($connection, $query_upd);

        if(!$result_upd) $err = mysqli_error($connection);
    }

        if($result) echo(json_encode(array('error'=>false)));
    else echo(json_encode(array('error'=>$err)));
?>