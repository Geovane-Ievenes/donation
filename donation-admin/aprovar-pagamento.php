<?php
include('./connection.php');

if(isset($_POST['aprovar'])){

    //UPLOAD DO COMPROVANTE DE DOAÇÃO
    $comprovante = $_FILES['comprovante-doc'];

    $tmp = explode('.', $comprovante["name"]);
    $ext = end($tmp);
    $nome_base = md5(uniqid(time())); 

    $nome_comprovante = $nome_base.'.'.$ext;
    $caminho_comprovante = '../comprovantes/' . $nome_comprovante;

    //INSERIR COMPROVANTE DE RECEBIMENTO NO BANCO DE DADOS
    $sql_com_recebimento = 'INSERT INTO tbcomprovantes (arquivo_comprovante, tipo_comprovante) VALUES ("'.$nome_comprovante.'", 2);';
    $result_com_recebiment = mysqli_query($connection, $sql_com_recebimento);
    if(! $result_com_recebiment) die('Erro ao adicionar comprovante de doações ao banco de dados: ' . mysqli_error($connection));

    $id_comp_recebimento = intval(mysqli_fetch_array(mysqli_query($connection, 'SELECT LAST_INSERT_ID()'))[0]);

    //DEPOIS DA OPERAÇÃO SER BEM SUCEDIDADE, MOVER ESSA IMAGEM PARA A PASTA DE COMPROVANTES
    if(!move_uploaded_file($comprovante["tmp_name"], $caminho_comprovante)){
        die('Erro ao fazer upload do comprovante de doação');
    }   

    //BUSCAR REGISTRO DA DOAÇÃO NO BANCO DE DADOS
    $id_doacao = $_POST['id_doacao'];

    $sql_s = 'SELECT * FROM tbdoacao WHERE id_doacao = '.$id_doacao;
    $result_s = mysqli_query($connection, $sql_s);
    if(!$result_s) die('Erro ao buscar informações da doação: ' . mysqli_error($connection));

    if(mysqli_num_rows($result_s) == 1){
        $doacao = mysqli_fetch_assoc($result_s);
        $quantia_doacao = intval($doacao['quantia_doacao']);

        //ADICIONAR VALOR DOADO A QUANTIA ARRECADADA DO PROJETO
        $sql_s_projeto = 'SELECT * FROM tbprojeto WHERE id_projeto = '.$doacao['id_projeto_doacao'];
        $result_s_projeto = mysqli_query($connection, $sql_s_projeto);
        if(!$result_s_projeto) die('Erro ao buscar projeto que vai receber doação: ' . mysqli_error($connection));
        else $montante_projeto = mysqli_fetch_assoc($result_s_projeto)['total_arrecadado'];

        $sql_upd_montante_projeto = 'UPDATE tbprojeto SET total_arrecadado = '.($montante_projeto + $quantia_doacao).' WHERE id_projeto = '.$doacao['id_projeto_doacao'];
        $result_upd_montante_projeto = mysqli_query($connection, $sql_upd_montante_projeto);
        if(!$result_upd_montante_projeto) die('Erro ao atualizar quantia de coins na carteira do doador: ' . mysqli_error($connection));

        //ADICIONAR COINS DO USUÁRIO QUE EFETUOU A DOAÇÃO   
        $coins_doacao = 0;

            //Decidir qual a quantia de coins que será adicionada a carteira do usuário
            switch($quantia_doacao){
                case 10:
                    $coins_doacao = 1;
                    break;
                case 20:
                    $coins_doacao = 5;
                    break;
                case 30:
                    $coins_doacao = 15;
                    break;
                case 50:
                    $coins_doacao = 40;
                    break;
                case 100:
                    $coins_doacao = 90;
                    break;
                case 500:
                    $coins_doacao = 500;
                    break;
            }

            //Buscar quantia atual de coins do usuário que doou
        $sql_s_usuario = 'SELECT * FROM tbusuario WHERE id_usuario = '.$doacao['id_doador_doacao'];
        $result_s_usuario = mysqli_query($connection, $sql_s_usuario);
        if(!$result_s_usuario) die('Erro ao buscar usuário que doou: ' . mysqli_error($connection));

        $qtd_coins_usuario = intval(mysqli_fetch_assoc($result_s_usuario)['qtd_coins_doador']);

            //Adicionar nations coins equivalentes da doação à carteira do usuário
        $sql_upd_coins_doador = 'UPDATE tbusuario SET qtd_coins_doador = '.($qtd_coins_usuario + $coins_doacao).' WHERE id_usuario = '.$doacao['id_doador_doacao'];
        $result_upd_coins_doador = mysqli_query($connection, $sql_upd_coins_doador);
        if(!$result_upd_coins_doador) die('Erro ao atualizar quantia de coins na carteira do doador: ' . mysqli_error($connection));

            //ATUALIZAR STATUS DA DOAÇÃO
        $sql_upd_doacao = 'UPDATE tbdoacao SET status = 1, id_comprovante_recebimento = "'.$id_comp_recebimento.'", data_confirmacao = CURRENT_DATE() WHERE id_doacao = '.$id_doacao;
        $result_upd_doacao = mysqli_query($connection, $sql_upd_doacao);
        if(!$result_upd_doacao) die('Erro ao atualizar status da doação e anexar comprovante: ' . mysqli_error($connection));

        header('location: doacoes.php');
    }   
}
?>