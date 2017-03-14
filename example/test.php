<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Hug\Log\Log as Log;

/* ************************************************* */
/* ***************** Log::write_log **************** */
/* ************************************************* */

$message = 'Hello world ! ';
$logfile = __DIR__ . '/test.log';
$result = Log::write_log($message, $logfile);
error_log('Write ' . $message . ' to file ' . $logfile . ' result : ' . print_r($result, true));

/* ************************************************* */
/* ************* Log::decode_log_level ************* */
/* ************************************************* */

$log_level_codes = [1, 2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048, 4096, 8192, 16384, 32767];
foreach ($log_level_codes as $key => $log_level_code)
{
	$log_message = Log::decode_log_level($log_level_code);
	error_log('Code : ' . $log_level_code . ' -> ' . $log_message);
}

