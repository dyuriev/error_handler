<?php
namespace DYuriev;

/*
* @author: Dmitriy Yuriev <coolkid00@gmail.com>
* @product: error_handler
* @version: 1.1.0
* @release date: 27.07.2014
* @development started: 15.07.2014
* @license: GNU AGPLv3 <http://www.gnu.org/licenses/agpl.txt>
*
* A small useful library that helps to handle PHP fatal errors and exceptions.
* Supports messages on two languages: russian and english.
*/


final class ErrorHandler
{
    private static $app_errors=array();
    private static $self_instance=null;

    private $mailer=null;
    private $message=null;
    private $config=array();

    public function __construct(\Swift_Mailer $mailer=null, \Swift_Message $message=null)
    {
        $this->mailer=$mailer;
        $this->message=$message;

        if($config=$this->loadConfig()) {

            $this->config=$config;
        }

        self::$self_instance=$this;
    }

    private function loadConfig()
    {
        $config_file=ERROR_HANDLER_DIR.'/config/config.php';

        if (file_exists($config_file) && is_readable($config_file)) {
            return include_once($config_file);
        }

        return false;
    }

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

    private function getExceptionTraceAsString(\Exception $exception)
    {
        $output = "";
        $count = 0;

        foreach ($exception->getTrace() as $frame) {

            $args = "";

            if (isset($frame['args'])) {

                $args = array();

                foreach ($frame['args'] as $arg) {

                    if (is_string($arg)) {
                        $args[] = "'" . $arg . "'";
                    } elseif (is_array($arg)) {
                        $args[] = "Array";
                    } elseif (is_null($arg)) {
                        $args[] = 'NULL';
                    } elseif (is_bool($arg)) {
                        $args[] = ($arg) ? "true" : "false";
                    } elseif (is_object($arg)) {
                        $args[] = get_class($arg);
                    } elseif (is_resource($arg)) {
                        $args[] = get_resource_type($arg);
                    } else {
                        $args[] = $arg;
                    }
                }

                $args = explode(", ", $args);
            }

            $output .= sprintf( "#%s %s(%s): %s(%s)\n",
                $count,
                isset($frame['file']) ? $frame['file'] : 'unknown file',
                isset($frame['line']) ? $frame['line'] : 'unknown line',
                (isset($frame['class'])) ? $frame['class'].$frame['type'].$frame['function'] : $frame['function'],
                $args );

            $count++;
        }

        return $output;
    }

    public static function configure(Array $config=null)
    {
        if(is_array($config) && count($config) > 0) {
            self::$self_instance->setConfig($config);
        }
    }

    public function setConfig(Array $config)
    {
        $this->config=array_merge($this->config,$config);
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

    private function prepareExceptionMessage(\Exception $exception)
    {
        ob_start();
        include_once(ERROR_HANDLER_DIR.'/templates/'.$this->config['lang'].'/mail.exception.tpl.php');
        $mail_body=ob_get_contents();
        ob_end_clean();

        $this->message->setSubject($this->config['mail_subject'])
        ->setFrom($this->config['mail_from'])
        ->setTo($this->config['mail_to'])
        ->setBody($mail_body,'text/html');

        return $this;
    }

    private function prepareErrorMessage()
    {
        ob_start();
        include_once(ERROR_HANDLER_DIR.'/templates/'.$this->config['lang'].'/mail.error.tpl.php');
        $mail_body=ob_get_contents();
        ob_end_clean();

        $this->message->setSubject($this->config['mail_subject'])
            ->setFrom($this->config['mail_from'])
            ->setTo($this->config['mail_to'])
            ->setBody($mail_body,'text/html');

        return $this;
    }

    private function sendMessage()
    {
        $this->mailer->send($this->message);
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

    public function handleException(\Exception $exception)
    {
        if(ob_get_level()) {
            ob_end_clean();
        }

        $err_container_file=ERROR_HANDLER_DIR.'/templates/'.$this->config['lang'].'/exception.tpl.php';
        header('HTTP/1.1 500 Internal Server Error', true, 500);
        include_once(ERROR_HANDLER_DIR.'/templates/main.tpl.php');

        if($this->config['is_send_emails'] && is_object($this->mailer) && is_object($this->message)) {
            $this->prepareExceptionMessage($exception)->sendMessage();
        }
    }

    public function printErrors()
    {
        if(ob_get_level()) {
            ob_end_clean();
        }

        $err_container_file=ERROR_HANDLER_DIR.'/templates/'.$this->config['lang'].'/error.tpl.php';
        header('HTTP/1.1 500 Internal Server Error', true, 500);
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

                if($this->config['is_send_emails'] && is_object($this->mailer) && is_object($this->message)) {
                    $this->prepareErrorMessage()->sendMessage();
                }
            }

            exit(1);
        }
    }

} 