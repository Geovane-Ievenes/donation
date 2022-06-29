<!DOCTYPE html>
    <html lang="en">
        <head>


            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=], initial-scale=1.0">
            <title>Resgatar Cupons</title>
    
        </head>

            <style>

                .cupon{

                    height: 250px;
                    margin-left: 50px;
                    width:10%;
                    background-color:#24b969;
             
                    }
                
                .cupon h4{

                  
                    text-align:center;
                    color:red;


                }
                
                input, button,submit { 
                    
                    border:none; 
                    background-color:#24b969;
                } 
                


            </style>
    
        <body>
            
            <section class="cupon">

                <form  method="post" action="cupon.php">

                <Input type="image" src value="clique" name="clique">
            
            </section>


    <?php

date_default_timezone_set('America/Sao_Paulo');

        if(isset($_POST['clique'])){


            echo('<link rel="stylesheet" type="text/css" href="style.css" >');

            $now = strtotime('now'); 
            $finish = date('d-m-Y', strtotime("+7 day", $now));

            echo($finish);

            
            if($now < $finish){

                echo("ainda não");

            }else{

                echo("foi");


        } 
        }


    
    
    
    ?>




        </body>
    </html>