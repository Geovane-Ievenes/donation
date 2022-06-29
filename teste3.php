<?php

$date = strtotime('now'); // your date
$newDate = date('d-m-Y', strtotime("+7 day", $date));

echo($newDate);

?>
