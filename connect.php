<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//MY CONNECTION
$_CON = mysqli_connect('mysql.hostinger.ph', 'u963832312_root', 'Jcq7oBRxRG8O', 'u963832312_grad');

if (!$_CON) {
    echo mysqli_connect_error() . PHP_EOL;
    exit;
}
// END CONNECTION
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////