<?php
    session_start();
    header('Content-Type: application/json; charset=utf-8');

    include('./connection.php');
    if(!isset($_POST)) die('Operação inválida');

    $id_req = intval($_POST['id']);

    $query_upd = 'UPDATE tbtentativa_cadastro SET situacao_tentativa = -1 WHERE id_tentativa = ' . $id_req;
    $result_upd = mysqli_query($connection, $query_upd);

    if(!$result_upd) $err = mysqli_error($connection);

    if($result_upd) echo(json_encode(array('error'=>false)));
    else echo(json_encode(array('error'=>$err)));
?>