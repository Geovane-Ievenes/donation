<?php
    session_start();
    include('./connection.php');
    include('./categorias_cod.php');
    if(!isset($_GET['cat']) || $_GET['cat'] > 5){
        header('location: loja.php?cat=1');
    }
    else{
        $cat = intval($_GET['cat']);
    }

    $cat_classes = Array('','','','','',''); //Aqui precisa ter o número de posuições correspondente a quantidade de categorias
    $cat_classes[$cat] = ' active';

    $nome_categoria = nomeCategoria($cat);

    $query_s = 'SELECT C.id_cupom, C.titulo_cupom AS titulo, C.valor_coins_cupom as coins, C.data_limite, P.nome_parceira AS parceira, P.logo_parceira as logo
    FROM tbcupons as C 
    INNER JOIN tbparceiras as P 
    ON C.id_parceira_cupom = P.id_parceira
    WHERE C.categoria_cupom = '.$cat .' AND CURRENT_DATE() <= C.data_limite';
    $result = mysqli_query($connection, $query_s);
    if(!$result) die('Falha ao buscar cupons no banco de dados');

    include('./head-page.php');
?>
    <title>Loja</title> 
    <style>
        .popup{
            position: fixed;
            top: 0; bottom: 0; 
            left: 0; right:0;
            margin: auto;
            width: 500px;
            height: 300px;
            padding: 10px;
            border: solid 1px none;
            border-radius: 10px;
            background: #fff;
            display: none;
            z-index: 3;
            overflow-y: auto;
        }

        .popup div {
            padding: 5px;
        }

        .popup div button {
            width: 150px;
            height: 60px;
            font-family: "FREDOKA ONE";
            border: none;
            background: #ffe879;
            border-radius: 10px;
            font-size: 16px;
            text-transform: uppercase;
            justify-content: center;
            align-items: center;
            margin: 0 145px 0;
        }

        #fechar:hover{
            cursor:pointer;
        }

        #cobrir-fundo{
            width: 100vw;
            height: 100vh;
            background-color: #000;
            opacity: 0.5;
            position: fixed;
            top: 0px;
            left: 0px;
            display: none;
            z-index: 2;
        }
    </style>
</head>
<body>
<?php
    include("./include/header.php");
?>

<!--POPUP-->
<div id="cobrir-fundo"></div>
<div id="popup" class="popup">
<span class="material-icons-outlined"  id="fechar" onclick="showCupomInfo(null, false)" width="20px" height="20px">close</span>

    <div class="popup-cupom-information">   
        <div class="imagem-loja">
            <img src="" alt="Logo Loja Cupom" width="130px" height="100px">
        </div>
        <div class="titulo-cupom">
            <h2 class="nome-projeto-popup"></h2>
        </div>
        <div class="loja-cupom">
            Loja: <span></span>
        </div>
        <div class="coins-cupom">
            Preço: <span></span> Nation Coins
        </div>
        <div class="descricao-cupom"></div>
            Descrição: <br>
            <textarea class="text-area" cols="30" rows="10" disabled></textarea>
        </div>
        <div class="aviso">
            <h2 style="text-align: center;">Tem certeza de que deseja resgatar o cupom ? </h2>
        </div>

        <div class="resgatar">
            <a class="resgatar" href="#"><button>Resgatar</button></a>
        </div>
    </div>
</div>

<div class="categorias">
    <div class="categorias-navbar">
    <a href="?cat=0" class="ctgr<?php echo($cat_classes[0]);?>">Calçados</a>
    <a href="?cat=1" class="ctgr<?php echo($cat_classes[1]);?>">Eletrodomésticos</a>
    <a href="?cat=2" class="ctgr<?php echo($cat_classes[2]);?>">Eletrônicos</a>
    <a href="?cat=3" class="ctgr<?php echo($cat_classes[3]);?>">Alimentícios</a>
    <a href="?cat=4" class="ctgr<?php echo($cat_classes[4]);?>">Artigos Esportivos</a>
    <a href="?cat=5" class="ctgr<?php echo($cat_classes[5]);?>">Jogos</a>
    </div>
</div>
<span class="titulo-cupom"></span>
   
<div class="cupons-sale-box">
    <h1 style="margin-bottom: 20px;"><?php echo($nome_categoria)?></h1>

    <div class="cupons-show">
        <?php
            while($reg = mysqli_fetch_assoc($result)){
                echo('
                    <div class="cupom" onclick="showCupomInfo('.$reg['id_cupom'].', true)">
                        <img src="./logo_lojas/'.$reg['logo'].'" alt="Logo Cupom" width="130px" height="100px"><br>
                        <span class="titulo-cupom"><strong>'.$reg['titulo'].'</strong></span><br>
                        <span class="coins-cupom">Preço: <strong>'.$reg['coins'].' Nation Coins</strong></span><br>
                        <span class="parceira-cupom">Loja: <strong>'.$reg['parceira'].'</strong></span><br>
                        <span class="data-limite-cupom">Válido até: <strong>'.$reg['data_limite'].'</strong></span><br>
                    </div>
                ');
            }
        ?>  
    </div>
</div>
<?php
    include("./include/footer.php");
?>
<script>
    var currentCupom = {};

    async function showCupomInfo(cupomId, popAction){
            var error = false;

            if(cupomId !== null && popAction){ //ABRIR POPUP SE O PROJETO EXISTE
                $.post("get_cupom_info_ajax.php", `id=${cupomId}`, function( dataObj ) {
                    if(typeof dataObj.error != undefined){
                        error = true;
                    }

                    //Data Has been sucessfully fetched
                    currentCupom = dataObj;
                    console.log(currentCupom);
                    fillPopupInfo();
                });

                if(error) alert('Impossível buscar o cupom desejado, tente mais tarde');
            }
            else{ //FECHAR POPUP
                $('#cobrir-fundo').hide();
                $('.popup').hide();
            }
        }

        function fillPopupInfo(){
            $('.imagem-loja img').attr('src', `./logo_lojas/${currentCupom.logo}`);
            $('.titulo-cupom span').html(currentCupom.titulo);
            $('.loja-cupom span').html(currentCupom.parceira);
            $('.coins-cupom span').html(currentCupom.coins);
            $('.text-area').text(currentCupom.descricao);

            //Popup
            $('#cobrir-fundo').show();
            $('.popup').show();
        }
</script>
</body>
</html>