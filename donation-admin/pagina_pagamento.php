<?php
	session_start();
	include('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Teste teste teste</title>
</head>
<body>
	<section>
		<?php echo('ID DO USUÁRIO QUE IRÁ FAZER A DOAÇÃO: ' . $_SESSION['id_usuario']);?>

		<form id="teste" name="teste" action="receber_pagamento.php" method="POST">
			<fieldset id=fieldset>
				<legend> Preencha para realizar a doação </legend>

				<label>Id projeto: </label>
				<input type="text" name="projeto"><br>


				<label>Quantia a ser doada:</label> 
				<select name="quantia_doacao" id="quantia_doacao">
					<option value="escolha" selected disabled></option>
					<option value="10">R$10,00</option>
					<option value="20">R$20,00</option>
					<option value="30">R$30,00</option>
					<option value="50">R$50,00</option>
					<option value="100">R$100,00</option>
					<option value="500">R$500,00</option>
				</select><br><br>

				<input type = "submit" name="doacao" value="Realizar doação"> <br><br>
				</fieldset>
			</form>	
	</section>
</body>
</html>