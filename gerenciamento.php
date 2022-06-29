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
    <title>Do.Nation - Seus Projetos</title>

    <link rel="stylesheet" href="./css/gerenciamento.css">
</head>
<body>
    <?php
        include("./include/header.php");
    ?>
    <main>
        <div class="content">
            <section>
                <h2 class="gerenciamento">Gerencie seu projeto</h2>
                <a href="meus-projetos.php">
                    <div class="left">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                    </div>
                </a>
            </section>
            <section>
              <h2 class="create">Criar Projeto</h2>
                <a href="cadastrar_projeto.php"> 
                    <div class="right">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </div>
                </div>
                </a>  
            </section>
        </div>
    </main>

    <?php
        include("./include/footer.php");
    ?>
</body>
</html>