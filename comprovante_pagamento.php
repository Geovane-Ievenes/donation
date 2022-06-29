<?php 
session_start();
include('./connection.php');
include('./head-page.php');

if(isset($_POST['doacao'])){
    $id_proj = $_POST['id-projeto'];
    $quantia_doacao = $_POST['quantia-doacao'];
    $logo_projeto = $_POST['logo_projeto'];
}
else{
    header('location: index.php');
}
?>
	<title>Pagamento</title>
	<link rel="stylesheet" href="comprovante_pg.css">
</head>
<body>
	<?php
		include("./include/header.php");
	?>	
    <section class="box-pagamento">
    <p class="qtd">Quantia selecionada:<div class="num-qtd">R$<?php echo($quantia_doacao);?>,00</div></p>
    <img src="./fotos_projeto/<?php echo($logo_projeto);?>" class="perfil-projeto">
    <p class="warning">* 5% da quantia doada será retirada pela plataforma, todo o restante será encaminhado para a instituição escolhida e o comprovante será enviado via email.</p>
    <section class="pix">
        <div class="pix-end">
            Chave Pix: do.nation@gmail.com
        </div>
    </section>
    <form action="receber_pagamento.php" id="form" method="POST" enctype="multipart/form-data">  
        <input type="hidden" name="id-projeto" value="<?php echo($id_proj);?>">
        <input type="hidden" name="quantia-doacao" id="amount" value="<?php echo($quantia_doacao);?>">
        <input type="hidden" name="logo_projeto" value="<?php echo($logo_projeto);?>">

        <input type="file" name="comprovante" value="comprovante" class="comprovante" id="comprovante" accept="image/png,image/jpeg,image/jpg"> 
        <label for="comprovante" class="input-comprovante">Insira o Comprovante de Doação</label>
        <input type="submit" name="finalizar" value="Finalizar Doação" class="fin-donate">
        <div id="file-name-space" style="margin-left: 20px;">
            <p class="file-name"></p>
        </div>
    </form>
    <script src="./js/file-validation.js"></script>
    <script>
        const fileName = document.querySelector('.file-name');
        const comprovante =  document.querySelector('#comprovante');
        const form =  document.querySelector('#form');

        var validProof = undefined;
        var proofHasBeenInserted = false;

        form.addEventListener('submit', (e)=>{
            if(!proofHasBeenInserted){
                alert('É necessário enviar o comprovante de transferência PIX');
                e.preventDefault();
            }
            if(validProof == false){
                alert('O arquivo que você está tentando enviar não é válido');
                e.preventDefault();
            }
        })

        function showName(FileInput){
            if(typeof FileInput.files[0] !== 'undefined'){
                fileName.innerText= FileInput.files[0].name;
            }
        }

        comprovante.addEventListener('change', (e)=>{
            let valid = validarArquivo(comprovante, null, 'image', 'proofPopup');
            if(valid){
                validProof = true;
                showName(comprovante);
            }
        })
    </script>
    </section>