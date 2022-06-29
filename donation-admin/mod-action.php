<?php
include('./head-preview.php');
include('../connection.php');
if(!isset($_GET['req'])) header('location: wellcome.php');

$id_req = $_GET['req']; 
$proj_id = $_GET['p'];

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
            if(status == 1) confirmMsg = 'Tem certeza de que deseja aprovar as mudanças ? ';
            else confirmMsg = 'Tem certeza de que deseja reprovar a alteração do projeto ? ';

            var confirmation = window.confirm(confirmMsg);
            if(!confirmation) return false;
            if(typeof confirmation == 'undefined') return false;

            var url = '';
            var parms = '';

            switch(status){
                case 0: 
                    var rej_msg = prompt('Qual o motivo pelo qual as informações do projeto não podem ser alteradas ?');
                    if(rej_msg == false || rej_msg == '' || typeof rej_msg == 'undefined') return false; //Nenhuma justificativa foi inserida

                    url = 'reject_changes.php';
                    // parms = {id:<?php //echo($id_req);?>, rej_msg : rej_msg};
                    parms = `id=<?php echo($id_req);?>&rej_msg=${rej_msg}`;
                break;
                case 1: 
                    url = 'validate_changes.php';
                    // parms = {id:<?php //echo($id_req);?>, p : <?php //echo($proj_id);?>};
                    parms = `id=<?php echo($id_req);?>`;
                break;
            }

            $(document).ajaxError(function(event,xhr,options,exc){
                console.log(options);
                alert(exc);
            });

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