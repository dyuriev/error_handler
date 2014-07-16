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

define('ERROR_HANDLER_DIR',__DIR__);
require_once(ERROR_HANDLER_DIR.'/class/ErrorHandler.class.php');

$error_handler=new ErrorHandler;

set_error_handler(function($err_no, $err_str, $err_file, $err_line) use ($error_handler) {
        $error_handler->handleError($err_no, $err_str, $err_file, $err_line);
    },E_ALL | E_STRICT);

set_exception_handler(function ($exception) use ($error_handler) {
        $error_handler->handleException($exception);
});

register_shutdown_function(function() use ($error_handler) {
        $error_handler->handleShutdown();
});