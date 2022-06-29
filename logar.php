<?php
    session_start();
    include('connection.php');

    if(!empty($_POST) && empty($_POST['email']) || empty($_POST['senha'])){
        echo('<script>window.alert("preencha os campos para continuar")</script>');
        echo('<script>window.location = "login.php"</script>');
        exit;
    }

    $email = $_POST['email'];
    $senha = sha1(trim($_POST['senha']));

    $query = "SELECT * FROM tbusuario WHERE email_usuario = '" . $email . "' AND senha_usuario = '" . $senha . "';";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result)){
        $reg = mysqli_fetch_assoc($result);

        $_SESSION['id_usuario'] = $reg['id_usuario'];
        $_SESSION['nome_usuario'] = $reg['nome_usuario'];
        $_SESSION['tipo_perfil'] = $reg['tipo_perfil'];
        $_SESSION['cod_perfil_ong'] = $reg['cod_perfil_ong'];
        
        header('location: index.php');
    }else{
        echo('<script>window.alert("Os dados inseridos estão incorretos")</script>');
        echo('<script>window.location = "login.php"</script>');
    }

?>

