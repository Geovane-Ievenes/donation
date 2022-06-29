<?php
    include('./connection.php');
    if(isset($_GET['cat'])){
        $cat = $_GET['cat'];
    }else{
        $cat = 1;
    }

    $where = 'WHERE C.Categoria_cupom = ' . $cat;

    $sql = 'SELECT C.id_cupom as id, C.titulo_cupom AS titulo, C.Categoria_cupom AS categoria, C.valor_coins_cupom AS coins, C.desconto_cupom_descricao AS descricao, inicio_ciclo_exibicao, fim_ciclo_exibicao
    FROM tbcupons as C
    INNER JOIN tbparceiras as P ON C.id_parceira_cupom = P.id_parceira
    ' . 
    $where . ' AND CURRENT_DATE() BETWEEN C.inicio_ciclo_exibicao AND  C.fim_ciclo_exibicao;';

    $result = mysqli_query($connection, $sql);
    if(!$result) echo('Errro ao buscar cupons: ' . mysqli_error($connection));

    function exibirCupom($titulo, $categoria, $descricao, $coins){
        echo('<li>
            <h3 class="c-title">'.$titulo.'</h3>
            <span class="c-category">'.$categoria.'</span>
            <p class="c-description">'.$descricao.'</p>
            <span class="c-coins">'.$coins.'</span>
        </li>');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupons</title>
    <style>
        ul li{
            background-color: #cecece;
            color: #0e0e0e; 
            margin: 10px 0px 0px 0px;
        }
    </style>

    <!--<p class="c-description"></p>
    <span class="c-question">Deseja mesmo resgatar o cupom ?</span>-->
</head>
<body>
    
    <ul>
        <?php
            $n_cupons = 0;
//<img src="./logo_lojas/'.$reg['logo_loja'].'" alt="Imagem Cupom" width="100%" height="100%">
            while($cupom = mysqli_fetch_assoc($result)){
                $data_atual = strtotime(date("Y-m-d"));

                $sql_s2 = 'SELECT * FROM tbtroca_cupons_loja WHERE id_cupom_troca = ' . $cupom['id'] . ' ORDER BY id_troca DESC limit 1';
                $result2 = mysqli_query($connection, $sql_s2);
                if(mysqli_num_rows($result2) == 1){ //Se a pessoa já tiver resgatado o cupom
                    $troca = mysqli_fetch_assoc($result2);
                    //verificar se a data atual é maior que 'data_novo_resgate' e se a data atual está dentro do ciclo de exdibição
                    $novo_resgate = strtotime($troca['data_novo_resgate']);
                    $inicio_ciclo = strtotime($cupom['inicio_ciclo_exibicao']);
                    $fim_ciclo = strtotime($cupom['fim_ciclo_exibicao']);

                    if(!($data_atual >= $novo_resgate) || !($data_atual >= $inicio_ciclo && $data_atual <= $fim_ciclo)){
                        continue; //pule essa etapa do while
                    }
                }

                //CASO A PESSOA NÃO TENHA RESGATADO ESSE CUPOM AINDA, OU JÁ POSSA RESGATÁ-LO NOVAMENTE...
                exibirCupom($cupom['titulo'], $cupom['categoria'], $cupom['descricao'], $cupom['coins']);
                $n_cupons++;
            }   

            if($n_cupons == 0){
                echo('Desculpe, não existem cupons disponíveis no momento :(');
            }
        ?>
    </ul>
</body>
</html>