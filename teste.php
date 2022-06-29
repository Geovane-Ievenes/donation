<?php
    date_default_timezone_set('America/Sao_Paulo');

    function IsExpireData($data){
        $data = explode(" ", $data);
        list($d, $m, $y) = explode('/', $data[0]);
        list($g, $i)     = explode(':', $data[1]);
        $dat0 = new DateTime(date("Y-m-d G:i:s", mktime($g, $i, 0, $m, $d, $y)));
        $dat1 = new DateTime(date("Y-m-d G:i:s"));

        $ret = '';
        if ($dat1 == $dat0) {
            $ret = 0;
        } else {
            if ($dat1 < $dat0){
                $ret = 1;
            } else {
                if ($dat1 > $dat0){
                    $ret = -1;
                }
            }
        }
        return $ret;
    }

    $d = IsExpireData("11/10/2021 12:00");
    if ($d == 0 || $d  == -1){
        echo 'Expirado';
    } else {
        echo 'Ainda não expirou';
    }
