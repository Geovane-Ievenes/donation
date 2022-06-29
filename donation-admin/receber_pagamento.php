<?php
	session_start();
	include('./connection.php');
	if(isset($_POST['doacao'])){
		
		$id_doador_doacao = $_SESSION['id_usuario'];
		$id_projeto = $_POST['projeto'];
		$quantia_doacao = intval($_POST['quantia_doacao']);
		$status = 0;
		date_default_timezone_set('America/Sao_Paulo');
		$theDate    = new DateTime('now');
	$stringDate = $theDate->format('Y-m-d H:i:s');


		$sqlin='insert into tbdoacao (id_projeto_doacao, id_doador_doacao, quantia_doacao, data_doacao,status) VALUES ('.$id_projeto.', '.$id_doador_doacao.', '.$quantia_doacao.',"'.$stringDate.'",'.$status.');';	

				$inserir = mysqli_query($connection,$sqlin);

				if($inserir){
					echo('Prezado(a) '.$id_projeto.' o valor da sua doação é R$: '.$quantia_doacao.' e será enviado para a Instituição '.$id_ong.'. Por favor, para finalizar realize a doação via PIX por meio da chave abaixo abaixo: <br><br>');
					echo('Chave Pix: do.nation@gmail.com');
				}else{
					echo ('hm tem erro ai');
				}	
	}

?>