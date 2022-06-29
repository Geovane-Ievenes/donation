<?php
include('./head-preview.php');
include('../connection.php');

if(!isset($_GET['req'])) header('location: wellcome.php');

$id_req = $_GET['req'];
    $query_s = 'SELECT SOLICITACAO.dir_documentos_tentativa AS dir_docs, SOLICITACAO.ext_doc_e AS ext_e, SOLICITACAO.ext_doc_cnd AS ext_cnd
                FROM tbperfil_ong AS ONG
                INNER JOIN tbtentativa_cadastro as SOLICITACAO
                ON SOLICITACAO.id_ong_tentativa = ONG.id_perfil_ong
                WHERE SOLICITACAO.id_tentativa = ' . $id_req;
    $result = mysqli_query($connection, $query_s);
    if(!$result) echo('Erro: ' . mysqli_error($connection));

    if(mysqli_num_rows($result) == 1) $reg = mysqli_fetch_assoc($result);
?>
<style>
    body{
        padding-left: 10px;
        padding-top: 10px;
    }
</style>
</head>
<body>
    <h2>Baixar documentos</h2>

    <span class="material-icons"><span class="material-icons-outlined">description</span></span><span></span>
        <span><a href="../documents/<?php echo($reg['dir_docs'] .'/' . $reg['dir_docs'] . 'e.'. $reg['ext_e']);?>" download>Estatuto social</a></span><br><br>

    <span class="material-icons"><span class="material-icons-outlined">description</span></span><span> </span>
        <span><a href="../documents/<?php echo($reg['dir_docs'] .'/' . $reg['dir_docs'] .'cnd.'. $reg['ext_cnd']);?>" download>CND</a></span><br><br>
</body>
</html>