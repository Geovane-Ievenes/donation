<?php
    session_start();
    include('./connection.php');

    if(isset($_GET['p'])){
        $error = false;
        $id_proj = $_GET['p'];

        if(is_nan($id_proj)) $error = true; //p não é um número

        $select_q = 'SELECT * from tbprojeto INNER JOIN tbperfil_ong ON tbprojeto.id_ong_projeto = tbperfil_ong.id_perfil_ong WHERE id_projeto = '.$id_proj.';';


        $result = mysqli_query($connection, $select_q);

        if(mysqli_num_rows($result) > 0){
            $reg = mysqli_fetch_assoc($result);
            $projectId = $reg['id_projeto'];
        }
        else $error = true;

    }

        $porcentagem = round((($reg['total_arrecadado']*100)/$reg['meta_projeto']));

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projeto</title>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link rel="stylesheet" href="projeto-pag.css">
        <link rel="stylesheet" href="./slider/slider_show_project.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <link rel="stylesheet" href="./include/header.css">
        <link rel="stylesheet" href="./include/footer.css">
        <link rel="stylesheet" href="./css/menu.css">
</head>
<body>

    <?php
        include("./include/header.php");
    ?>

<main class="content-project">
    <h3 id="title" class="info-field">
        <?php echo($reg['nome_projeto']);?>
    </h3>

    <img id="foto" src="./fotos_projeto/<?php echo($reg['logo_projeto']);?>">

    <p id="nome" class="info-field">
        Nome da ong:
        <?php
            echo($reg['nome_ong'])
        ?>
    </p>

    <p id="meta" class="info-field">
        Meta do projeto:
        <?php 
            echo($reg['meta_projeto']);
        ?>
    </p>

    <p id="andamento">
        Andamento do projeto:

        <div class="progress-bar">
            <p id="myProgress">
            <p id="myBar">10%</p>
        </div>
    </p>

            <br> 

        <script> 
        const porcentagem = <?php echo($porcentagem)?>;
        var width = 0;
        
        if(porcentagem >= 0 && porcentagem <= 100) width = porcentagem;

        else if(porcentagem < 0) width = 0;
        else width = 100;

        var elem = document.getElementById("myBar");

        elem.style.width = width + "%";
        elem.innerHTML = porcentagem  + "%";
        </script>  
    </p>

    <p id="definicao">
        Definição do Projeto:
    </p>
    <p id="txt" class="info-field">
        <?php echo($reg['descricao_projeto']);?>
    </p>  
    <p id="slider">
        <?php 
            $rota_imagens = './fotos_projeto';

            $img_novas = []; //Não existem imagens a se acrescentar
            $img_existentes = []; //As imagens que serão exibidas ficarão aqui

            /*Obter imagens do projeto*/ 
            $query_img_p = 'SELECT imagem_projeto FROM tbimagens WHERE id_projeto_imagem = '. $id_proj;
            $result_img = mysqli_query($connection, $query_img_p);
            if(!$result_img) die('Erro ao buscar imagens do projeto: ' . mysqli_error($connection));

            while($img = mysqli_fetch_assoc($result_img)){
                array_push($img_existentes, $img['imagem_projeto']); //Adicionando imagens do projeto à listagem
            }

            include('./slider/slider-just-show.php');
        ?>
        <script src="./slider/slider-just-show.js"></script>
    </p>
    <section id="doar-b-box">
        <button id="doar" onclick=" location.href = 'pagina_pagamento.php?p=<?php echo($id_proj);?>'">Doar</button>
    </section>

</main>
    <?php
        include("./include/footer.php");
    ?>
    <script>
        
    </script>
</body>
</html> 