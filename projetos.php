<?php
    session_start();
    include('./connection.php'); //Conexão Global

    function getProjectInfo($ods){
        $connection = mysqli_connect(HOST, USER, PASSWORD, BD); //Conexão Privada

        $select_query = 'SELECT * FROM tbprojeto WHERE JSON_EXTRACT(ODS, "$.ods'.$ods.'") <> "false"';
        $search_result = mysqli_query($connection, $select_query);

        if(!$search_result){
            echo('Erro ao buscar projetos no base de dados: ' . mysqli_error($connection));
            exit;
        }
        return $search_result;
    }
    
include('./head-page.php');
?>
    <title>Aba Projetos - Do.Nation</title>
    <link rel="stylesheet" href="projetos.css">

    <style>
        /*Project Popup inputs*/ 
        .nome-projeto-popup{
            font-size: 30px;
            font-family: "FREDOKA ONE";
        }

        /*Single Image*/ 

        .projeto ul li:hover{
            opacity: 0.95;
            /*Zoom da imagem*/ 
        }
    </style>
</head>
<body>
    <?php
        include("./include/header.php");
    ?> 
    <main>
        <div id="cobrir-fundo"></div>
        <div id="popup" class="popup">
            <span class="material-icons-outlined"  id="fechar" onclick="exibitionPopup(null, false)" width="20px" height="20px">close</span>
            <div class="popup-project-information">
                <div class="title-project">
                    <h2 class="nome-projeto-popup"></h2>
                </div>
                <div class="content-project">
                    <div class="temas">
                        <span class="temas-projeto-popup"></span>
                    </div>
                    <div class="data">
                        Criação do Projeto: <span class="criacao-projeto-popup"></span>
                    </div>
                    <div class="meta">
                        Meta: R$ <span class="meta-projeto-popup"></span>
                    </div>
                </div>
                <div>
                    <a class="view" href="#"><button>Vizualizar projeto</button></a>
                </div>
            </div>
        </div>

        <div class="content-projects">
            <div class="section-projects secao-um">
                <h2 class="title">Fome zero</h2>
                <div class="projeto" id="p1">
                    <ul>
                        <?php
                            $result = getProjectInfo(2); //EXIBIR PROJETOS DA ODS 2

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 8) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 8) echo('<a href="#" class="mais">Ver mais</a>');
                    
                        if(mysqli_num_rows($result) == 0){
                            echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                        }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-dois">
                <h2 class="title">Saúde e bem-estar</h2>
                <div class="projeto" id="p2">
                    <ul>
                        <?php
                            $result = getProjectInfo(3); //EXIBIR PROJETOS DA ODS 3

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 8) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 8) echo('<a href="#" class="mais">Ver mais</a>');
                    
                        if(mysqli_num_rows($result) == 0){
                            echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                        }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-tres">
                <h2 class="title">Educação de Qualidade</h2>
                <div class="projeto" id="p3">
                    <ul>
                        <?php
                            $result = getProjectInfo(4); //EXIBIR PROJETOS DA ODS 4

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" height="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 3) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 3) echo('<a href="#" class="mais">Ver mais</a>');
                    
                        if(mysqli_num_rows($result) == 0){
                            echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                        }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-um">
                <h2 class="title">Igualdade de gêneros</h2>
                <div class="projeto" id="p4">
                    <ul>
                        <?php
                            $result = getProjectInfo(5); //EXIBIR PROJETOS DA ODS 2

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 8) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 8) echo('<a href="#" class="mais">Ver mais</a>');
                    
                        if(mysqli_num_rows($result) == 0){
                            echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                        }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-dois">
                <h2 class="title">Água potável e saneamento</h2>
                <div class="projeto" id="p5">
                    <ul>
                        <?php
                            $result = getProjectInfo(6); //EXIBIR PROJETOS DA ODS 3

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 8) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 8) echo('<a href="#" class="mais">Ver mais</a>');
                    
                        if(mysqli_num_rows($result) == 0){
                            echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                        }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-tres">
                <h2 class="title">Energia limpa e acessível</h2>
                <div class="projeto" id="p6">
                    <ul>
                        <?php
                            $result = getProjectInfo(7); //EXIBIR PROJETOS DA ODS 4

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" height="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 3) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 3) echo('<a href="#" class="mais">Ver mais</a>');
                    
                        if(mysqli_num_rows($result) == 0){
                            echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                        }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-tres">
                <h2 class="title">Trabalho descente e crescimento econômico</h2>
                <div class="projeto" id="p6">
                    <ul>
                        <?php
                            $result = getProjectInfo(8); //EXIBIR PROJETOS DA ODS 4

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" height="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 3) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 3) echo('<a href="#" class="mais">Ver mais</a>');
                    
                        if(mysqli_num_rows($result) == 0){
                            echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                        }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-tres">
                <h2 class="title">Redução das desigualdades</h2>
                <div class="projeto" id="p6">
                    <ul>
                        <?php
                            $result = getProjectInfo(10); //EXIBIR PROJETOS DA ODS 4

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" height="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 3) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 3) echo('<a href="#" class="mais">Ver mais</a>');
                    
                        if(mysqli_num_rows($result) == 0){
                                echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                        }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-tres">
                <h2 class="title">Cidades e comunidades sustentáveis</h2>
                <div class="projeto" id="p6">
                    <ul>
                        <?php
                            $result = getProjectInfo(11); //EXIBIR PROJETOS DA ODS 4

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" height="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 3) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 3) echo('<a href="#" class="mais">Ver mais</a>');
                    
                        if(mysqli_num_rows($result) == 0){
                            echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                        }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-tres">
                <h2 class="title">Consumo e produção responsáveis</h2>
                <div class="projeto" id="p6">
                    <ul>
                        <?php
                            $result = getProjectInfo(12); //EXIBIR PROJETOS DA ODS 4

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta; 

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" height="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 3) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 3) echo('<a href="#" class="mais">Ver mais</a>');
                    
                        if(mysqli_num_rows($result) == 0){
                            echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                        }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-tres">
                <h2 class="title">Ação contra a mudança global do clima</h2>
                <div class="projeto" id="p6">
                    <ul>
                        <?php
                            $result = getProjectInfo(13); //EXIBIR PROJETOS DA ODS 4

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" height="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 3) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 3) echo('<a href="#" class="mais">Ver mais</a>');
                    
                        if(mysqli_num_rows($result) == 0){
                            echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                        }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-tres">
                <h2 class="title">Vida na água</h2>
                <div class="projeto" id="p6">
                    <ul>
                        <?php
                            $result = getProjectInfo(14); //EXIBIR PROJETOS DA ODS 4

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" height="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 3) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 3) echo('<a href="#" class="mais">Ver mais</a>');
                    
                    if(mysqli_num_rows($result) == 0){
                        echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                    }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-tres">
                <h2 class="title">Vida terrestre</h2>
                <div class="projeto" id="p6">
                    <ul>
                        <?php
                            $result = getProjectInfo(15); //EXIBIR PROJETOS DA ODS 4

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;
                                
                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" height="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 3) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 3) echo('<a href="#" class="mais">Ver mais</a>');
                    
                    if(mysqli_num_rows($result) == 0){
                        echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                    }
                    ?>
                </div>
            </div>
            <div class="section-projects secao-tres">
                <h2 class="title">Paz, justiça e instituições eficazes</h2>
                <div class="projeto" id="p6">
                    <ul>
                        <?php
                            $result = getProjectInfo(16); //EXIBIR PROJETOS DA ODS 4

                            $n_projeto = 1; //NÚMERO DO PROJETO A SER IMPRIMIDO

                            while($reg = mysqli_fetch_assoc($result)){
                                /*Diminuindo descrição do projeto*/ 
                                $desc_longa = $reg['descricao_projeto'];
                                $desc_curta = substr($desc_longa, 0, 48) . '...';

                                $reg['descricao_projeto'] = $desc_curta;

                                echo('<li class="card">
                                        <div class="card_div" width="auto" height="350px">
                                            <img src="fotos_projeto/'.$reg['logo_projeto'].'" alt="'.$reg['nome_projeto'].'" width="210px" height="210px" class="project-img" onclick="exibitionPopup('.$reg['id_projeto'].', true)">
                                            <div class="propriedades_projeto">
                                                <span class="nome_projeto">'.$reg['nome_projeto'].'</span>
                                                <span class="description_projeto">'.$reg['descricao_projeto'].'</span>
                                            </div>
                                        </div>
                                    </li>');

                                if(++$n_projeto > 3) break;
                            }
                        ?>
                    </ul>
                    <?php if($n_projeto > 3) echo('<a href="#" class="mais">Ver mais</a>');
                    
                    if(mysqli_num_rows($result) == 0){
                        echo('<p style="margin-top: 20px;">Nenhum projeto dessa categoria foi encontrado</p>');
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <?php
        include("./include/footer.php");
    ?>
    <script src="./js/get-theme-name.js"></script>
    <script>
        var currentProject;

        async function exibitionPopup(projectId, popAction){
            var error = false;

            if(projectId !== null && popAction){ //ABRIR POPUP SE O PROJETO EXISTE
                $.post("get_project_info_ajax.php", `id=${projectId}`, function( dataObj ) {
                    if(typeof dataObj.error != undefined){
                        error = true;
                    }
                    //Data Has sucessfully fetched
                    currentProject = dataObj;
                    /*Atualizar formato da data de criação do projeto*/ 
                    let oldDateFormat = currentProject.data_criacao_projeto;
                    let newDateFormat = oldDateFormat.split('-').reverse().join('/');

                    currentProject.data_criacao_projeto = newDateFormat;
                    fillPopupInfo();
                });

                if(error) alert('Impossível buscar dados da ONG neste momento');
            }
            else{ //FECHAR POPUP
                $('#cobrir-fundo').hide();
                $('.popup').hide();
            }
        }

        function fillPopupInfo(){
            $('.nome-projeto-popup').html(currentProject.nome_projeto);

            let allThemesCode = JSON.parse(currentProject.temas_projeto);
            let showThemesArr = [];
            for(let i = 0; i < allThemesCode.length; i++){
                let theme = getThemeName(allThemesCode[i]);
                showThemesArr.push(theme);
            }
            $('.temas-projeto-popup').html(showThemesArr.join(' | '));

            $('.criacao-projeto-popup').html(currentProject.data_criacao_projeto);
            $('.meta-projeto-popup').html(currentProject.meta_projeto);

            $('.view').attr("href",`projeto-pag.php?p=${currentProject.id_projeto}`);
            //Popup
            $('#cobrir-fundo').show();
            $('.popup').show();
        }
    </script>
</body>
</html>