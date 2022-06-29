<?php
    session_start();
    if(isset($_SESSION['adm'])){
        header('location: painel.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation | Menu Administrativo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style>

        #container{
            height: 100vh;
            background-color: #fefeee;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box{
            height: 50%;
            width: 45%;
            background-color: #fefefe;
            color: #0e0e0e;
            border: 3px solid rgba(0,0,0,0.9);
            border-radius: 1%;
            box-shadow: 5px 5px rgba(0,0,0,0.9);

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .box-header{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 25%;
        }

        .login-box #form{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body>

    <main id="container" class="container-fluid">
        <section class="login-box">
            <section class="box-header">
                <img src="./logo_r.png" alt="Logo Donation" width="100px" heigth="100px">
                <h2 style="font-family: 'Open Sans'; text-align: center;">Menu Administrativo</h2>
            </section>
            

            <form action="login.php" method="POST" id="form" style="margin-top: 20px;">

                Nome de Usuário: <input type="text" id="email" name="email" autocomplete="off"><br> 
                Senha: <input type="password" id="senha" name="senha"><br>

                <button class="btn btn-primary btn-lg" onclick="$('#form').submit()">Login</button>
            </form>
        </section>
    </main>
    
</body>
</html>