<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
            
<?php

        include('conexao.php');
    session_start();

        $cpf=50138757810;
        $data= $_SESSION['data'];
        $nome=$_SESSION['nome'];
        $cat=$_SESSION['cat'];

    $agora = date('Y/m/d');
                    echo $agora;
                    $select='SELECT * FROM `tbregistro` WHERE  cpf='.$cpf.' and data_troca >="'.$agora.'"';
                    $feito=mysqli_query($connection,$select);
                    echo(mysqli_error($connection));
        
                    ?>

                    <form name=cupons action="pronto.php" method="post" id="form">
                    <input type="hidden" name="cupom-escolhido" class="cupom-escolhido">
                    <?php

                    while($con=mysqli_fetch_array($feito)){

                        echo('<br>');
                        echo($ola1=$con['0']);

                        echo('
                            <input type="submit" id='.$con['0'].' value="'.$con['3'].'" name="oi" class="oi" onclick="changeCurrentCupom(this.id)">    
                        ');
                    }
                    ?>    
                    </form>
                
                        <?php

                     
                    if(isset($_POST['oi'])){

                        $id_cupom = $_POST['cupom-escolhido'];
            

                        $update="update tbregistro set data_troca='2002-01-01 ' where id_troca=".$id_cupom."";
                        $update1=mysqli_query($connection,$update);
                      

                        

                
                   }
                    ?>



                    
                    
                        
         

<script>
    const form = document.querySelector('#form');
    const botao = document.querySelector('.oi');

    function changeCurrentCupom(id){
        let hidden = document.querySelector('.cupom-escolhido');
        hidden.value = id;
    }
</script>
</body>
</html>