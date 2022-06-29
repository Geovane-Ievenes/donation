<?php
    function nomeCategoria($codigo){
        switch($codigo){
            case 0:
                return 'Calçados';
                break;
            case 1:
                return 'Eletrodomésticos';
                break;
            case 2:
                return 'Eletrônicos';
                break;
            case 3:
                return 'Alimentícios';
                break;
        }
    }
?>
