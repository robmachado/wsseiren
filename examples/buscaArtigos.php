<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use Fimatec\Seiren\Tools;
use Fimatec\Seiren\Standardize;

$config = (object) [
    'cnpj' => '99.999.999/0001-99',
    'token' => '65656-333-3-KL111E-45323FQ',
    'tpamb' => 2
];

$tools = new Tools($config);

$resp = $tools->artigos();

$std = (new Standardize())->toStd($resp); 

echo "<pre>";
print_r($std);
echo "</pre>";

//header("Content-type: text/xml");
//echo $resp;
