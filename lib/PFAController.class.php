<?php
// $id$

/**
 * @package PFAPath
 * Configuration Class
 * 
 * @version $Revision: $:
 * @author $Author: $:
 * @date $Date: $:
 */

 class PFAController {
 
	/**
   * @access private
   * @var object instance
   * Singleton-Instanz des FrontControllers
   */
  private static $instance = null;
 
	function __consturct () {
		
	}
	
	function getInstance () {
		if(self::$instance === null) {
			self::$instance = new PFAController();
		}
        return self::$instance;
   }


 
 }
 
 
 /* vim: set expandtab softtabstop=4 tabstop=4 shiftwidth=4: */