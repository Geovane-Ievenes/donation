<?php
session_start();
if(!isset($_SESSION['adm'])){
    header('location: index.php');
}

include('./head-preview.php');
?>
<style>
    body{
        width: 100vw;
        height: 100vh;
    }

    .wellcome-section{
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .wellcome-section span{
        font-size: 2.5em;
        color: #708090;
        text-align: center;
    }
</style>
<body>
    <div class="wellcome-section">
        <span class="material-icons"><span class="material-icons-outlined">waving_hand</span></span><br>
        <span class="wellcome-message">Bem vindo de volta <strong><?php echo($_SESSION['adm']);?> !!</strong></span>
    </div>
</body>
</html>