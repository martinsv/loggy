<?php
require_once '../src/SLog.php';

$arr = array('Key 1' => 'Value 1', 'Key 2' => 2);

Slog::debug('Debug 1');
SLog::error('Error 1');
Slog::notice('Notice 1');
Slog::debug($arr);


$slog = Slog::getLogger();
$slog->debug('Debug 2');
$slog->error('Error 2');
$slog->notice('Notice 2');
$slog->debug($arr);