<?php
/**
 * index.php
 * 
 * This file starts the session, configures error reporting and exception
 * handling, loads the autoloader, and starts the applications main (front)
 * controller.
 */

//Start the session.
session_start();

//Suppress fatal errors.
error_reporting(0);

//Register a function to handle non-catchable exceptions.
//This occurs at the entry-point of the application to achieve
// maximum code coverage.
if (!isset($_SESSION['SHUTDOWN_FUNCTION_REGISTERED']) || 
        $_SESSION['SHUTDOWN_FUNCTION_REGISTERED'] === FALSE ) {
    
    /**
     * Executed when an error that can't be caught with a try-catch
     * block is thrown.
     */
    function shutDownFunction() { 
        $error = error_get_last();
        // fatal error, E_ERROR === 1
    //    if ($error['type'] === E_STRICT) { 
            echo "<BR/>FROM SHUTDOWN FUNCTION:<BR/>";
            var_dump($error);
    //    } 
    }
    
    register_shutdown_function('shutDownFunction');
    $_SESSION['SHUTDOWN_FUNCTION_REGISTERED'] = TRUE;
}

//Require class autoloader.
require_once __DIR__ . '/autoload.php';

//Establish default exception handler.
//if (!isset($_SESSION['DEFAULT_EXCEPTION_HANDLER_REGISTERED']) || $_SESSION['DEFAULT_EXCEPTION_HANDLER_REGISTERED'] === FALSE) {
//    
////    $exceptionHandler = new ExceptionHandler($exception)
//    set_error_handler(array(new ExceptionHandler(), 'getAll'));
//$_SESSION['DEFAULT_EXCEPTION_HANDLER_REGISTERED'] = TRUE;
//}


try {
    
//    throw new Exception("Custom exception", 200);
    $controller = new FrontController();
    $controller->processRequest();
} catch (Exception $ex) {
    echo "no exception was thrown";
//    echo $ex->getMessage();
//    echo "<br/>" . $ex->getCode();
//    echo "<br/>" . $ex->getLine();
//    echo "<br/>" . $ex->getFile();
//    echo "<br/>" . $ex->getTraceAsString();
    var_dump($ex);
}