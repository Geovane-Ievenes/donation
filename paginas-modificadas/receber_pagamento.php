<?php
	session_start();
	include('./connection.php');

	if(isset($_POST['finalizar']) && isset($_SESSION['id_usuario'])){
		$id_proj = $_POST['id-projeto'];
		$quantia_doacao = $_POST['quantia-doacao'];

		date_default_timezone_set('America/Sao_Paulo');
		$theDate = new DateTime('now');
		$stringDate = $theDate->format('Y-m-d H:i:s');

		//Enviar imagem do projeto
        $comprovante = $_FILES['comprovante'];
        $dir_imagens = 'comprovantes/';

        //Mover fotos do Comprovante e armazenar nomes para guardar no banco
		$tmp = explode('.', $comprovante["name"]);
		$ext = end($tmp);

		$nome_base = md5(uniqid(time())); 
		$nome_arq = $nome_base . '.' . $ext;
		$caminho_arq = $dir_imagens . $nome_arq;

		if(!move_uploaded_file($comprovante["tmp_name"], $caminho_arq)){
			die('Erro ao fazer upload da logo do projeto: ' . mysqli_error($connection));
		}

		//Adicionar novo comprovante
		$sql_comprovante ='insert into tbcomprovantes (arquivo_comprovante, tipo_comprovante) VALUES ("'.$nome_arq.'", 1);';	//Tipo 1 é comprovante de recebimento
		$result_comprovante = mysqli_query($connection, $sql_comprovante);
		if(!$result_comprovante) die('Erro aoInserir comprovante no banco de dados: ' . mysqli_error($connection));

		$id_comprovante = intval(mysqli_fetch_array(mysqli_query($connection, 'SELECT LAST_INSERT_ID()'))[0]); //Retorna o id do último registro do perfil inserido

		$sqlin ='insert into tbdoacao (id_projeto_doacao, id_doador_doacao, quantia_doacao, data_doacao, id_comprovante_doacao, status) VALUES ('.$id_proj.', '.$_SESSION['id_usuario']	.','.$quantia_doacao.',"'.$stringDate.'","'.$id_comprovante.'", 0);';	
		$inserir = mysqli_query($connection,$sqlin);
		if(!$inserir) die('Erro ao registrar doação no banco de dados: ' . mysqli_error($connection));

		echo('<script>alert("Doação efetuada com sucesso !! Em breve você poderá conferir na página de histórico de doações o comprovante de recebimento da sua doação.")</script>');
		echo('<script>location.href = "projetos.php"</script>');
	}
	else {
		header('location: index.php');
	}
?>