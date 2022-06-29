<!DOCTYPE html>
<html lang="pt_br">
<?php 
session_start();
include('./head-page.php');
?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="criacao.css">
        <link rel="stylesheet" href="./include/header.css">
        <link rel="stylesheet" href="./include/header.css">

            <title>Cupom</title>
    
    </head>
    <body>

    <div class="box-ilustration">
        <img src="./imagens/vector-cop-pg" class="img-vector">
    </div>
    <div class="box-form">
        <h2>Insira um Cupom</h2>
        <form action="criacao.php" method="post">

            <input type="text" name="nome" class="nome_coupon" placeholder="Nome do cupom">
            
         
            
            <label class="cat_coupon">Categoria do Cupom:</label>
            <div class="opcoes"><input type="radio" name="cat" value="1 "> Alimentos</div>
            <div class="opcoes"><input type="radio" name="cat" value="2"> Eletrônicos</div>
            <div class="opcoes"><input type="radio" name="cat" value="3"> Livros</div>
            <div class="opcoes"><input type="radio" name="cat" value="4"> Jogos</div>
            
            <label class="date_coupon">Data de Expiração:</label>

            <input type="date" name="data_limite" placeholder="Data limite">

            <input type="number" name="number" class="value_text" placeholder="Valor de NationCoins">
            
            <input type="submit" value="Gerar Cupom" name="criar" >
 

        </form>  

    </div>
            <?php

            
            date_default_timezone_set('America/Sao_Paulo');
            $connection = mysqli_connect('localhost', 'root', '', 'teste');


                if(isset($_POST['criar'])){

            if(!empty($_POST) && empty($_POST['nome'])  || empty($_POST['data_limite']) || empty($_POST['cat'])){
            
                       echo('<script>window.alert("preencha os campos para continuar")</script>');
            }else{  
                
                   



                        session_start();

                        $_SESSION['data'] = $_POST['data_limite'];
                        $_SESSION['nome']= $_POST['nome'];
                        $_SESSION['cat'] = $_POST['cat'];
                        $_SESSION['number']=$_POST['number'];

                        $data= $_SESSION['data'];
                        $nome=$_SESSION['nome'];
                        $cat=$_SESSION['cat'];
                        $num=$_SESSION['number'];
               
                            $banco="insert into tbcupom (nome_cupom,categoria,data_limite,coins)     Values ( '".$nome."','".$cat."','".$data."',".$num.")";
                            $dito=mysqli_query($connection,$banco);

                            $select= "select cpf from tbusuario_exemplo";
                            $sl1=mysqli_query($connection,$select);

                            While($con=mysqli_fetch_array($sl1)){

                            $insert='insert into tbregistro (data_troca,cpf,nome_cupom_troca) values("'.$data.'",'.$con['0'].',"'.$nome.'")';

                            $ins1=mysqli_query($connection,$insert);
                            }

                           header('location:pronto.php');
        

                    
                            
                            

            }
                    }

            ?>
    










        </form>

    </body>
</html>