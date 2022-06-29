<?php
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
?>