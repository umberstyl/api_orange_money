<?php

// easy ntegraton full class
require_once '../src/configuration.php';
require_once '../src/OrangeMoneyApi.php';

//convert http requested data as json;
$data = isset($_REQUEST) ? json_encode($_REQUEST) : [];

$process = true;

?>

<!DOCTYPE html>
<html>
<link href="style.css" rel="stylesheet">

<body>
    <?php
    if (isset($_REQUEST['omoney']) && $_REQUEST['omoney'] == "mpayment") {
        //use Api_Orange_Money\OrangeMoneyApi;
        $api_om = new OrangeMoneyApi($data, false);
        $mp = 1;
        $Om = $api_om->deposite();
    } elseif (isset($_REQUEST['omoney']) && $_REQUEST['omoney'] == "cashout") {
        //use Api_Orange_Money\OrangeMoneyApi;
        $api_om = new OrangeMoneyApi($data, false);
        $mp = 0;
        $Om = $api_om->cashout();
    } else {
        $process = false;
        include 'form.php';
    }
    if ($process) {
        $Om = $api_om->check_status($Om);
        include 'payment.php';
    }
    ?>

</body>

</html>