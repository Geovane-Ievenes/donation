<?php
    header('Content-Type: application/json; charset=utf-8');

    include('./connection.php');
    if(!isset($_POST)) die('Falha ao buscar cupom');

    $id = $_POST['id'];

    $select_query = 'SELECT C.id_cupom, C.titulo_cupom AS titulo, C.valor_coins_cupom as coins, C.desconto_cupom_descricao AS descricao, P.nome_parceira AS parceira, P.logo_parceira as logo
    FROM tbcupons as C 
    INNER JOIN tbparceiras as P 
    ON C.id_parceira_cupom = P.id_parceira
    WHERE C.id_cupom = '.$id .';';
    
    $result = mysqli_query($connection, $select_query);

    if($result) echo(json_encode(mysqli_fetch_assoc($result)));
    else echo(json_encode(array('error'=>true)));
?>