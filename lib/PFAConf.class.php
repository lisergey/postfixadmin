<?php
// $id$

/**
 * @package PFA_Conf
 * Configuration Class
 * 
 * 
 * @version $Revision: $:
 * @author $Author: $:
 * @date $Date: $:
 */
 
/**
 * Configuration Class
 *
 */
class PFAConf {
/**
 * Determine if $__objects cache should be wrote
 *
 * @var boolean
 * @access private
 */
        var $__cache = false;
/**
 * Holds and key => value array of objects type
 *
 * @var array
 * @access private
 */
        var $__objects = array();

/**
 * Return a singleton instance of Configure.
 *
 * @return Configure instance
 * @access public
 */

        function &getInstance() {
                static $instance = array();
                if (!$instance) {
                        $instance[0] = new PFAConf();
                        //$instance[0]->__loadBootstrap($boot);
                }
                return $instance[0];
        }
/**
 * Used to write a dynamic var in the Configure instance.
 *
 * Usage
 * Configure::write('One.key1', 'value of the Configure::One[key1]');
 * Configure::write(array('One.key1' => 'value of the Configure::One[key1]'));
 * Configure::write('One', array('key1'=>'value of the Configure::One[key1]', 'key2'=>'value of the Configure::One[key2]');
 * Configure::write(array('One.key1' => 'value of the Configure::One[key1]', 'One.key2' => 'value of the Configure::One[key2]'));
 *
 * @param array $config Name of var to write
 * @param mixed $value Value to set for var
 * @return void
 * @access public
 */
        function write($config, $value = null) {
                $_this =& PFAConf::getInstance();

                if (!is_array($config)) {
                        $config = array($config => $value);
                }

                foreach ($config as $names => $value) {
                        $name = $_this->__configVarNames($names);

                        switch (count($name)) {
                                case 3:
                                        $_this->{$name[0]}[$name[1]][$name[2]] = $value;
                                break;
                                case 2:
                                        $_this->{$name[0]}[$name[1]] = $value;
                                break;
                                case 1:
                                        $_this->{$name[0]} = $value;
                                break;
                        }
                }

        }

/**
 * Used to read Configure::$var
 *
 * Usage
 * Configure::read('Name'); will return all values for Name
 * Configure::read('Name.key'); will return only the value of Configure::Name[key]
 *
 * @param string $var Variable to obtain
 * @return string value of Configure::$var
 * @access public
 */
        function read($var, $default = NULL) {
                $_this =& PFAConf::getInstance();
                
                if ($var === 'all') {
                        $return = array();
                        foreach ($_this AS $key =>$var) {
                                $return[$key] = $var;
                        }
                        return $return;
                }

                $name = $_this->__configVarNames($var);

                switch (count($name)) {
                        case 3:
                                if (isset($_this->{$name[0]}[$name[1]][$name[2]])) {
                                        return $_this->{$name[0]}[$name[1]][$name[2]];
                                }
                        break;
                        case 2:
                                if (isset($_this->{$name[0]}[$name[1]])) {
                                        return $_this->{$name[0]}[$name[1]];
                                }
                        break;
                        case 1:
                                if (isset($_this->{$name[0]})) {
                                        return $_this->{$name[0]};
                                }
                        break;
                }
                return $default;
        }

        
        function getAll() {
                $output = $this->config;
                return $output;
        }
/**
 * Checks $name for dot notation to create dynamic Configure::$var as an array when needed.
 *
 * @param mixed $name Name to split
 * @return array Name separated in items through dot notation
 * @access private
 */
        function __configVarNames($name) {
                if (is_string($name)) {
                        if (strpos($name, ".")) {
                                return explode(".", $name);
                        }
                        return array($name);
                }
                return $name;
        }

        /**
         * 
         *
         *
         *
         */
        function load($filename) {
          $_this =& PFAConf::getInstance();
          if (file_exists(LIB . $filename . '.config.php')) {
            include(LIB . $filename . '.config.php');
            $found = true;
          } elseif (file_exists($filename . '.config.php')) {
            include($filename . '.config.php');
            $found = true;
          } else {
            $found = false;
          }   
          
          if($found) {
            $vars = get_class_vars('Configuration');
            foreach ($vars AS $key => $var) {
              $_this->write($key, $var);
            }
          }
        }
}

/* vim: set expandtab softtabstop=4 tabstop=4 shiftwidth=4: */