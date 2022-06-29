<?php
    header('Content-Type: application/json; charset=utf-8');

    include('./connection.php');
    if(!isset($_POST)) header('location: cadastro.php');

    $email = $_POST['email'];
    $has_repeated_email = mysqli_query($connection, 'SELECT * FROM tbusuario WHERE email_usuario = "'.$email.'";');

    $response = (mysqli_num_rows($has_repeated_email) > 0) ? array('already_exists'=>true) : array('already_exists'=>false);
    echo(json_encode($response));
?>