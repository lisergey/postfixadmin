<?php
// $id$

/**
 * @package PFA
 * Boot
 * 
 * @copyright 
 * @version $Revision: $:
 * @author $Author: $:
 * @date $Date: $:
 */

/**
 * Basic defines for timing functions.
 */
	define('SECOND', 1);
	define('MINUTE', 60);
	define('HOUR', 3600);
	define('DAY', 86400);
	define('WEEK', 604800);
	define('MONTH', 2592000);
	define('YEAR', 31536000);
  
  
 /**
 * @param string $class
 * __autoload implementation, for use with spl_autoload_register().
 */
function postfixadmin_autoload($class) {

    $class = preg_replace('/(?<=\\w)(?=[A-Z])/',"_$1", $class);
    $class = strtolower($class);
    $path = $class . '.class.php';
    if(is_file(ROOT . $path)) {
        require_once(ROOT . $path);
        return true;
    } elseif(is_file(LIB . $path)) {
        require_once(LIB . $path);
        return true;
    } elseif(is_file($path)) {
        require_once($path);
        return true;
    }
    return false;
}
spl_autoload_register('postfixadmin_autoload');
  
function boot() {
  Conf::load('main');
  Conf::load('local');
}
  
