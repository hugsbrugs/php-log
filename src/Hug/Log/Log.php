<?php

namespace Hug\Log;

/**
 *
 */
class Log
{
    /**
     * https://web.stanford.edu/dept/its/communications/webservices/wiki/index.php/How_to_create_logs_with_PHP
     * // Filename of log to use when none is given to write_log
     * define("DEFAULT_LOG","/afs/ir/your-home-directory/logs/default.log");
     *
     * write_log($message[, $logfile])
     *
     * Author(s): thanosb, ddonahue
     * Date: May 11, 2008
     * 
     * Writes the values of certain variables along with a message in a log file.
     *
     * Parameters:
     *  $message:   Message to be logged
     *  $logfile:   Path of log file to write to.  Optional.  Default is DEFAULT_LOG.
     *
     * Returns array:
     *  $result[status]:   True on success, false on failure
     *  $result[message]:  Error message
     */
    public static function write_log($message, $logfile = null)
    {
        $response = ['status' => false, 'message' => ''];

        # Determine log file
        if($logfile===null)
        {
            # checking if the constant for the log file is defined
            if (defined(DEFAULT_LOG))
            {
                $logfile = DEFAULT_LOG;
            }
            # the constant is not defined and there is no log file given as input
            else
            {
                error_log('No log file defined!',0);
                $response['message'] = 'No log file defined!';
            }
        }
        if($logfile!==null)
        {
            # Get time of request
            if( ($time = $_SERVER['REQUEST_TIME']) == '')
            {
                $time = time();
            }
            # Format the date and time
            $date = date("Y-m-d H:i:s", $time);

            # Get IP address
            $remote_addr = '';
            if(!empty($_SERVER['REMOTE_ADDR']))
            {
                $remote_addr = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $remote_addr = "REMOTE_ADDR_UNKNOWN";
            }

            # Get requested script
            $request_uri = '';
            if(!empty($_SERVER['REQUEST_URI']))
            {
                $request_uri = $_SERVER['REQUEST_URI'];
            }
            else
            {
                $request_uri = "REQUEST_URI_UNKNOWN";
            }

            # Append to the log file
            if($fd = @fopen($logfile, "a"))
            {
                $result = fputcsv($fd, [$date, $remote_addr, $request_uri, $message]);
                fclose($fd);

                if($result > 0)
                {
                    $response['status'] = true;
                }
                else
                {
                    $response['message'] = 'Unable to write to '.$logfile.'!';
                }
            }
            else
            {
                $response['message'] = 'Unable to open log '.$logfile.'!';
            }
        }
        return $response;
    }

    /**
     * Transforms a PHP integer error code into a human readable PHP constant
     *
     * Source : http://php.net/manual/fr/errorfunc.constants.php
     *
     * @param int $error_code
     *
     * @return string $log_level
     *
     */
    public static function decode_log_level($error_code)
    {
        $log_level = null;

        # force error_code to be an integer if not
        if(!is_integer($error_code))
        {
            $error_code = intval($error_code);
        }

        # all available error codes
        $log_level_codes = [
            1 => 'E_ERROR',
            2 => 'E_WARNING',
            4 => 'E_PARSE',
            8 => 'E_NOTICE',
            16 => 'E_CORE_ERROR',
            32 => 'E_CORE_WARNING',
            64 => 'E_COMPILE_ERROR',
            128 => 'E_COMPILE_WARNING',
            256 => 'E_USER_ERROR',
            512 => 'E_USER_WARNING',
            1024 => 'E_USER_NOTICE',
            2048 => 'E_STRICT',
            4096 => 'E_RECOVERABLE_ERROR',
            8192 => 'E_DEPRECATED',
            16384 => 'E_USER_DEPRECATED',
            32767 => 'E_ALL',
        ];

        # is error_code indexed un log_level_codes ?
        if(isset($log_level_codes[$error_code]))
        {
            $log_level = $log_level_codes[$error_code];
        }

        return $log_level;
    }

}
