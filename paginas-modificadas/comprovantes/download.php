<?php
if(isset($_GET['document'])){
    $doc = $_GET['document'];

    $tmp = explode('.', $doc);
    $ext = end($tmp);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donwload...</title>
</head>
<body>
    <?php echo('<a class="doc-link" href="http://localhost/donation101/comprovantes/'.$_GET['document'].'" download="comprovante_recebimento.'.$ext.'"></a>');?>
    <script>
        document.querySelector('.doc-link').click();
        window.location.href = "http://localhost/donation101/registros-doacao.php";
    </script>
</body>
</html>
