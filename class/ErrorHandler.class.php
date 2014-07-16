<?php
namespace DYuriev;

/*
* @author: Dmitriy Yuriev <coolkid00@gmail.com>
* @product: error_handler
* @version: 1.0
* @release date: 16.07.2014
* @development started: 15.07.2014
* @license: GNU AGPLv3 <http://www.gnu.org/licenses/agpl.txt>
*
* A small useful library that helps to handle PHP fatal errors and exceptions.
* Supports messages on two languages: russian and english.
*/


final class ErrorHandler
{

    private static $app_errors=array();
    private static $lang='en';
    private static $show_debug=false;

    private function getErrTypeByIntCode($type)
    {
        switch($type)
        {
            case E_ERROR: // 1 //
                return 'E_ERROR';
            case E_WARNING: // 2 //
                return 'E_WARNING';
            case E_PARSE: // 4 //
                return 'E_PARSE';
            case E_NOTICE: // 8 //
                return 'E_NOTICE';
            case E_CORE_ERROR: // 16 //
                return 'E_CORE_ERROR';
            case E_CORE_WARNING: // 32 //
                return 'E_CORE_WARNING';
            case E_CORE_ERROR: // 64 //
                return 'E_COMPILE_ERROR';
            case E_CORE_WARNING: // 128 //
                return 'E_COMPILE_WARNING';
            case E_USER_ERROR: // 256 //
                return 'E_USER_ERROR';
            case E_USER_WARNING: // 512 //
                return 'E_USER_WARNING';
            case E_USER_NOTICE: // 1024 //
                return 'E_USER_NOTICE';
            case E_STRICT: // 2048 //
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR: // 4096 //
                return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED: // 8192 //
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED: // 16384 //
                return 'E_USER_DEPRECATED';
        }
        return false;
    }

    public static function setDebug($show_debug=false)
    {
        self::$show_debug=$show_debug;
    }

    public static function setLang($lang='en')
    {
        self::$lang=$lang;
    }

    public static function getAppErrors()
    {
        return self::$app_errors;
    }

    private function getErrTypeByInt($type)
    {
        switch($type)
        {
            case 1: // 1 //
                return 'E_ERROR';
            case 2: // 2 //
                return 'E_WARNING';
            case 4: // 4 //
                return 'E_PARSE';
            case 8: // 8 //
                return 'E_NOTICE';
            case 16: // 16 //
                return 'E_CORE_ERROR';
            case 32: // 32 //
                return 'E_CORE_WARNING';
            case 64: // 64 //
                return 'E_COMPILE_ERROR';
            case 128: // 128 //
                return 'E_COMPILE_WARNING';
            case 256: // 256 //
                return 'E_USER_ERROR';
            case 512: // 512 //
                return 'E_USER_WARNING';
            case 1024: // 1024 //
                return 'E_USER_NOTICE';
            case 2048: // 2048 //
                return 'E_STRICT';
            case 4096: // 4096 //
                return 'E_RECOVERABLE_ERROR';
            case 8192: // 8192 //
                return 'E_DEPRECATED';
            case 16384: // 16384 //
                return 'E_USER_DEPRECATED';
        }
        return false;
    }

    public function handleError($err_no, $err_str, $err_file, $err_line)
    {
        self::$app_errors[]=array(
            'LEVEL'=>$this->getErrTypeByIntCode($err_no),
            'MESSAGE'=>$err_str,
            'FILE'=>$err_file,
            'LINE'=>$err_line,
            'ERROR'=>"<i>".$this->getErrTypeByIntCode($err_no)."</i>: $err_str in file <i>$err_file</i> on line <i>$err_line</i>"
        );
    }

    public function handleException(Exception $exception)
    {
        if(ob_get_level()) {
            ob_end_clean();
        }

        $err_container_file='exception.'.self::$lang.'.tpl.php';
        include_once(ERROR_HANDLER_DIR.'/templates/main.tpl.php');
    }

    public function printErrors()
    {
        if(ob_get_level()) {
            ob_end_clean();
        }

        $err_container_file='error.'.self::$lang.'.tpl.php';
        include_once(ERROR_HANDLER_DIR.'/templates/main.tpl.php');
    }

    public function handleShutdown()
    {
        $error = error_get_last();

        if ($error && ($error['type'] == E_ERROR || $error['type'] == E_PARSE || $error['type'] == E_COMPILE_ERROR)) {

            if (strpos($error['message'], 'Allowed memory size') === 0) {
                ini_set('memory_limit', (intval(ini_get('memory_limit'))+64)."M");
            }

            self::$app_errors[]=array(
                'LEVEL'=>$this->getErrTypeByInt($error['type']),
                'MESSAGE'=>$error['message'],
                'FILE'=>$error['file'],
                'LINE'=>$error['line']
            );

            if(count(self::$app_errors) > 0) {
                $this->printErrors();
            }

            exit(1);
        }
    }

} 