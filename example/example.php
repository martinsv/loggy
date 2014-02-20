<?php
require_once '../lib/Loggy.php';

$arr = array('Key 1' => 'Value 1', 'Key 2' => 2);

Loggy\Loggy::debug('Debug 1');
Loggy\Loggy::error('Error 1');
Loggy\Loggy::notice('Notice 1');
Loggy\Loggy::debug($arr);


$loggy = Loggy\Loggy::getLogger();
$loggy->debug('Debug 2');
$loggy->error('Error 2');
$loggy->notice('Notice 2');
$loggy->debug($arr);