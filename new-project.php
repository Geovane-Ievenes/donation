<?php
    session_start();
    include('./connection.php');
    

    if(isset($_POST['criar'])){
        $nome_projeto=$_POST['nome_projeto'];

        $tmp_meta_projeto = str_replace(['.',','], ['', '.'], $_POST['meta_projeto']);
        $meta_projeto=floatval($tmp_meta_projeto);

        $descricao_projeto=$_POST['descricao_projeto'];
        $email_projeto=$_POST['email_projeto'];
        $facebook_projeto=$_POST['facebook_projeto'];
        $instagram_projeto=$_POST['instagram_projeto']; 
        $twitter_projeto=$_POST['twitter_projeto'];
        $temas = json_encode($_POST['chosed-goals']); //Metas no sentido de objetivos
       
        //Obter ODS selecionada pelo usuário em um formato JSON correto
        $ods_assoc_arr = ['ods2'=>"false", 'ods3'=>"false",'ods4'=>"false",'ods5'=>"false",'ods6'=>"false",'ods7'=>"false",'ods8'=>"false",'ods10'=>"false",'ods11'=>"false",'ods12'=>"false",'ods13'=>"false",'ods14'=>"false",'ods15'=>"false",'ods16'=>"false"];

        $tmp_ods_str = str_replace(['[',']','"'], '', $_POST['chosed-ODS']);
        $ods_arr = array_unique(explode(',', $tmp_ods_str));
        
        for($c = 2; $c <= 16; $c++){
            if(array_search($c, $ods_arr) !== false){
                $ods_assoc_arr['ods' . $c] = "true";
            }
        }
        $ods_json = json_encode($ods_assoc_arr);

        //Informações para envio de imagens
        $logo_projeto = $_FILES['logo_projeto'];
        $qtd_sliders = $_POST['sliders-count'];
        $imagens_sliders = [];
        $dir_imagens = 'fotos_projeto/';

        //Mover fotos do Slider e armazenar nomes para guardar no banco
        for($i = 0; $i < $qtd_sliders; $i++){
            $imagens_sliders[$i] = $_FILES['file' . $i];

            $tmp = explode('.', $imagens_sliders[$i]["name"]);
            $ext = end($tmp);

            $nome_base = md5(uniqid(time())); //O nome é o mesmo, mas cada arquivo terá um sufixo para identificar qual é o slide
            $nome_arq = $nome_base . 's' . $i . '.' . $ext;
            $caminho_arq = $dir_imagens . $nome_arq;
    
            if(!move_uploaded_file($imagens_sliders[$i]["tmp_name"], $caminho_arq)){
                die('Erro ao fazer upload dos documentos: ' . mysqli_error($connection));
            }

            $nome_img_sliders[$i] = $nome_arq;
        }

        //Mover foto de perfil e guardar nome da foto no banco
        preg_match("/\.(png|jpeg|jpg){1}$/i", $logo_projeto["name"], $ext);

        $nome_imagem = md5(uniqid(time())).'P.'.$ext[1]; 
        $caminho_imagem = $dir_imagens . $nome_imagem;

        if(!move_uploaded_file($logo_projeto["tmp_name"], $caminho_imagem)){
            echo('Erro ao gravar foto de perfil');
            exit;
        }

        $novo_projecto_query = 'INSERT INTO tbprojeto (id_ong_projeto,nome_projeto, logo_projeto, meta_projeto, total_arrecadado, descricao_projeto, email_projeto, facebook_projeto, instagram_projeto, twitter_projeto, ODS, temas_projeto, qtd_sliders, data_criacao_projeto) VALUES ('.$_SESSION['cod_perfil_ong'].',"'.$nome_projeto.'","'.$nome_imagem.'",'.$meta_projeto.', 0, "'.$descricao_projeto.'","'.$email_projeto.'","'.$facebook_projeto.'","'.$instagram_projeto.'","'.$twitter_projeto.'",\''.$ods_json.'\','.$temas.','.$qtd_sliders.',CURRENT_DATE())';
        $result = mysqli_query($connection, $novo_projecto_query);
        if(!$result){
            echo('Erro ao cadastrar projeto: ' . mysqli_error($connection));
            exit;
        }

        $id_projeto_inserido = intval(mysqli_fetch_array(mysqli_query($connection, 'SELECT LAST_INSERT_ID()'))[0]);


        foreach($nome_img_sliders as $img){
            $ins_img_query = 'INSERT INTO tbimagens (id_projeto_imagem,imagem_projeto, tipo_imagem) VALUES ('.$id_projeto_inserido.', "'.$img.'", 1)';
            $result = mysqli_query($connection, $ins_img_query);
            if(!$result){
                echo('Erro ao criar registro da imagem ' . key($nome_img_sliders) . ': ' . mysqli_error($connection));
                exit;
            }
        }

        header('location: gerenciamento.php');
    }   
?>