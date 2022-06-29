<?php 
    session_start();
    include('./connection.php');
    if(isset($_SESSION['nome_usuario'])){
        if(!isset($_SESSION['cod_perfil_ong'])){
            header('location: index.php'); // não é ONG
            exit;
        }

        $sql_cad_ong = 'SELECT * FROM tbcadastro_ong WHERE id_ong_cadastro = ' . $_SESSION['cod_perfil_ong'];
        $result_cad_ong = mysqli_query($connection, $sql_cad_ong);

        if(!$result_cad_ong) die(mysqli_error($connection));

        $sql_req = 'SELECT situacao_tentativa FROM tbtentativa_cadastro WHERE id_ong_tentativa = ' . $_SESSION['cod_perfil_ong'] . ' ORDER BY id_tentativa DESC limit 1';
        $result_req = mysqli_query($connection, $sql_req);

        if(!$result_req) die(mysqli_error($connection));

        $req = mysqli_fetch_assoc($result_req);

        if($req['situacao_tentativa'] == -1){
            echo('<script>window.alert("Infelizmente sua solicitação de cadastro como ONG foi RECUSADA. Caso acredite que ocorreu um erro na validação de suas informações, entre em contato no e-mail: do.nation@gmail.com")</script>');
            echo('<script>window.location = "index.php"</script>');
        }   
        elseif(!mysqli_num_rows($result_cad_ong) > 0){
            echo('<script>window.alert("Você ainda não tem permissão para criar ou editar projetos. O processo de aprovação de uma ONG leva em torno de duas semanas para ser concluído.")</script>');
            echo('<script>window.location = "index.php"</script>');
        }  
    }   
    else{
        header('location: logout.php');
    }
 
include('./head-page.php');
?>
    <title>gerenciamento-projetos</title>
    <link rel="stylesheet" href="meus-projetos.css">
</head>
<body>
    <?php
        include("./include/header.php");
    ?>

    <div id="projeto">
        <p class="title">Meus Projetos</p> 
        <ul>
            <?php 
                $select_proj_editar = 'SELECT * FROM tbprojeto WHERE id_ong_projeto = '. $_SESSION['cod_perfil_ong'];
                $result_proj_editar = mysqli_query($connection, $select_proj_editar);

                while($reg = mysqli_fetch_assoc($result_proj_editar)){
                    echo('<li id="'.$reg['id_projeto'].'" onclick="redirectToEdit(this.id)"><img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="Imagem projeto" width="100%" height="100%"><br><span class="nome-projeto">'.$reg['nome_projeto'].'</span></li>');
                }
                if(mysqli_num_rows($result_proj_editar) == 0) echo('<span>Você ainda não criou nenhum projeto, <a href="cadastrar_projeto.php">crie um aqui!!</a></span>');
            ?>
        </ul>
    </div>
    <?php
        include("./include/footer.php");
    ?>
    <script>
        function redirectToEdit(projectId){
            location.href = `edicao-projeto.php?p=${projectId}`;
        }
    </script>
</body>
</html>