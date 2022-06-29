<?php
include('./head-preview.php');
include('../connection.php');
if(!isset($_GET['req'])) header('location: wellcome.php');

$id_req = $_GET['req'];
$id_ong = $_GET['ong'];
?>
<style>
    body{
        padding-top: 10px;
    }

    .buttons{
        display: flex;
        justify-content: space-evenly;
        padding-top: 10px;
    }
</style>
</head>

<body>
    <h2 style="text-align: center;">Informe o status da solicitação da ONG: </h2>
    <div class="buttons">
        <button type="button" class="btn btn-danger btn-lg" onclick="Action(0)">Reprovado</button>
        <button type="button" class="btn btn-success btn-lg" onclick="Action(1)">Aprovado</button>
    </div>
    <script>
        function Action(status){ 
            var confirmMsg = '';
            if(status == 1) confirmMsg = 'Tem certeza de que deseja aprovar a solicitação ? ';
            else confirmMsg = 'Tem certeza de que deseja reprovar a solicitação ? ';

            var confirmation = window.confirm(confirmMsg);
            if(!confirmation) return false;
            if(typeof confirmation == 'undefined') return false;

            var url = '';
            var parms = '';

            switch(status){
                case 0: 
                    url = 'reject_ong_ajax.php';
                    parms = `id=<?php echo($id_req);?>`;
                break;
                case 1: 
                    url = 'validate_ong_ajax.php';
                    parms = `id=<?php echo($id_req);?>&ong=<?php echo($id_ong);?>`;
                break;
            }

            $.post(url, parms, function( dataObj ) {
                if(dataObj.error){
                    var error = true;
                }
                //Data Has sucessfully fetched
                if(typeof error != 'undefined') alert(dataObj.error);
                else window.parent.location.reload();
            });
        }
    </script>
</body>
</html>