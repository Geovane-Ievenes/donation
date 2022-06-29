<?php 
session_start();
include('./connection.php');
include('./head-page.php');

//Verificar se está logado
if(!isset($_SESSION['id_usuario'])){
	header('location: login.php');
}

//Obter informações do projeto
if(isset($_GET['p'])){
	$id_proj = $_GET['p'];

	$sql_s = 'SELECT ONG.nome_ong, PROJ.nome_projeto, PROJ.logo_projeto
	FROM tbprojeto as PROJ
	INNER JOIN tbperfil_ong as ONG
	ON PROJ.id_ong_projeto = ONG.id_perfil_ong
	WHERE id_projeto = '. $id_proj;
	$result = mysqli_query($connection, $sql_s);
	if(!$result) die('Erro ao buscar projeto na base de dados: ' . mysqli_error($connection));

	$reg = mysqli_fetch_assoc($result);
}
else{
	header('location: projetos.php');
}

?>

	<title>Pagamento</title>
	<link rel="stylesheet" href="pagina_pagamento.css">
</head>
<body>
	<?php
			include("./include/header.php");
	?>	
		<section class="box-pagamento">

			<form id="form" name="teste" action="comprovante_pagamento.php?p=<?php echo($id_proj);?>" method="POST">
					<section class="form-left">
						<img src="./fotos_projeto/<?php echo($reg['logo_projeto']);?>" class="perfil-projeto">
						<label class="projeto" >Projeto: <?php echo($reg['nome_projeto']);?></label>
						<label class="criador" >Proprietário: <?php echo($reg['nome_ong']);?></label>
					</section>	

					<section class="form-right">
					<label class="qtd">Quantia a ser doada:</label> 
					<div class="opcoes">
						<div class="radio"><input type="radio" name="doacao" value="10" onchange="updateAmount(this)"> R$10,00</div>
						<div class="radio"><input type="radio" name="doacao" value="20" onchange="updateAmount(this)"> R$20,00</div>
						<div class="radio"><input type="radio" name="doacao" value="30" onchange="updateAmount(this)"> R$30,00</div>
						<div class="radio"><input type="radio" name="doacao" value="40" onchange="updateAmount(this)"> R$40,00</div>
						<div class="radio"><input type="radio" name="doacao" value="50" onchange="updateAmount(this)"> R$50,00</div>
						<div class="radio"><input type="radio" name="doacao" value="100" onchange="updateAmount(this)"> R$100,00</div>
						<div class="radio"><input type="radio" name="doacao" value="500" onchange="updateAmount(this)"> R$500,00</div>
					</div>

					<input type="hidden" name="id-projeto" value="<?php echo($id_proj);?>">
					<input type="hidden" name="quantia-doacao" id="amount" value="0">
					<input type="hidden" name="logo_projeto" value="<?php echo($reg['logo_projeto']);?>">
					
					<input type = "submit" name="doacao" id="submit-button" value="Realizar doação">
			</form>	
	</section>	
	<script>
		const quantiaDoar = document.querySelector('#amount'),
			  form = document.querySelector('#form');

		function updateAmount(radioButton){
			if(radioButton.checked){
				quantiaDoar.value = parseInt(radioButton.value);
			}
		}

		form.addEventListener('submit', (e)=>{
			if(quantiaDoar.value == 0) {
				alert('Escolha uma quantia para doar !!');
				e.preventDefault();
			}
		})
	</script>
</body>	
</html>