<?php
    header('Content-Type: application/json; charset=utf-8');

    include('./connection.php');
    if(!isset($_POST)) die('não tem post n :(');

    $id = $_POST['id'];
    $select_query = 'SELECT * FROM tbprojeto WHERE id_projeto = '.$id.';';
    $result = mysqli_query($connection, $select_query);

    if($result) echo(json_encode(mysqli_fetch_assoc($result)));
    else echo(json_encode(array('error'=>true)));
?>