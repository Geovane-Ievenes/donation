<?php
    include("./connection.php");

    if(!isset($_POST['finalizar'])){
        echo('<script>header("location: login.php")</script>');
        exit;
    }

    //Variáveis para query sql
    $sql_coluna_perfil;
    $cod_perfil;

    //  Dados do usuário
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $password = sha1(trim($_POST['senha']));
    $aniversario = $_POST['birthday'];
    $genero = $_POST['gender'];
    $pattern_dados = array('-', '/', '.', ' ');
    $cpf_usuario = str_replace($pattern_dados, '', $_POST['cpf_usuario']);

    // include('proc-docs.php');
    
    if(isset($_POST['sou-ong'])){    
        $tipo_perfil = 'ong';

        // Importar dados de uma ONG
        $pattern_dados = array('-', '/', '.', ' ');

        $nome_ong = $_POST['name_ong']; 
        $fundacao_ong = $_POST['fundation_ong'];
        $descricao_ong = $_POST['description_ong'];
        $tel_ong = ($_POST['tel_ong'] == '') ? null : str_replace($pattern_dados, '', $_POST['tel_ong']);
        $cel_ong = ($_POST['cel_ong'] == '') ? null : str_replace($pattern_dados, '', $_POST['cel_ong']);
        $cnpj_ong = str_replace($pattern_dados, '', $_POST['cnpj_ong']);
        var_dump($cpf_usuario);
        $cep_ong = str_replace($pattern_dados, '', $_POST['cep_ong']);
        $arq_estatuto = $_FILES['estatuto'];
        $arq_cnd = $_FILES['cnd'];

        //Criar pefil para ong
        $sql_c_perfil = 'INSERT INTO tbperfil_ong (nome_ong, fundacao_ong,descricao_ong,CNPJ_ong,CEP_ong,telefone_comercial_ong,celular_ong) VALUES ("'.$nome_ong.'","'.$fundacao_ong.'","'.$descricao_ong.'","'.$cnpj_ong.'","'.$cep_ong.'","'.$tel_ong.'","'.$cel_ong.'");';
        
        $result_perfil = mysqli_query($connection, $sql_c_perfil);
        if(!$result_perfil){
            die('Erro ao criar perfil de usuário no banco de dados para a ONG: <br><br>' . mysqli_error($connection));
        }

        $id_perfil = intval(mysqli_fetch_array(mysqli_query($connection, 'SELECT LAST_INSERT_ID()'))[0]); //Retorna o id do último registro do perfil inserido
        $id_perfil_c_usuario = ',' . $id_perfil;
    }
    else{
        $tipo_perfil = 'doador'; //Será utilizado mais tarde para especificar o tipo de perfil do usuário
        $id_perfil_c_usuario = '';
    }
    
    if($tipo_perfil == 'ong') $sql_coluna_perfil = ',cod_perfil_ong'; //Relacionar com perfil Ong
    else $sql_coluna_perfil = '';

    //criar usuário (dados para login da pessoa)
    $sql_c_usuario = 'INSERT INTO tbusuario (nome_usuario,email_usuario,senha_usuario,data_criacao_usuario,nascimento_usuario,cpf_usuario,sexo_usuario,tipo_perfil'.$sql_coluna_perfil.') VALUES ("'.$usuario.'","'.$email.'","'.$password.'",CURRENT_DATE(),"'.$aniversario.'",'.$cpf_usuario.',"'.$genero.'","'.$tipo_perfil.'"'.$id_perfil_c_usuario .');';
    $result_usuario = mysqli_query($connection, $sql_c_usuario);
  
    if(!$result_usuario){
        echo(mysqli_error($connection));  
        die('Erro ao criar registro de usuário');

    }

    //CRIAR TENTATIVA DE REGISTRO PARA ONG
    if($tipo_perfil == 'ong'){
        /*Mover Arquivos para pasta documents */ 
        $tmpe = explode('.', $arq_estatuto["name"]);
        $tmpcnd = explode('.', $arq_cnd["name"]);

        $ext_e = end($tmpe);
        $ext_cnd = end($tmpcnd);

        $nomedir = md5(uniqid(time())); 
        mkdir('./documents/' . $nomedir); 

        $nome_arq_estatuto = $nomedir . 'e.' . $ext_e;
        $nome_arq_cnd = $nomedir . 'cnd.' . $ext_cnd;

        $caminho_arq_estatuto = 'documents/' . $nomedir . '/' . $nome_arq_estatuto;
        $caminho_arq_cnd = 'documents/' . $nomedir . '/' . $nome_arq_cnd;

        if(!move_uploaded_file($arq_estatuto["tmp_name"], $caminho_arq_estatuto) ||
        !move_uploaded_file($arq_cnd["tmp_name"],  $caminho_arq_cnd)
        ){
            die('Erro ao fazer upload dos documentos');
        }

        $sql_c_tentativa_cad = 'INSERT INTO tbtentativa_cadastro (id_ong_tentativa,data_tentativa,dir_documentos_tentativa, ext_doc_e, ext_doc_cnd) VALUES ('.$id_perfil.',CURRENT_DATE(), "'.$nomedir.'", "'.$ext_e.'", "'.$ext_cnd.'");';

        $result_tentativa = mysqli_query($connection, $sql_c_tentativa_cad);
        if(!$result_tentativa){
            die('Erro ao criar tentativa de cadastro no banco de dados para a ONG registrada: <br><br>' . mysqli_error($connection));
        } 
      
    }  header('location:login.php');

?>