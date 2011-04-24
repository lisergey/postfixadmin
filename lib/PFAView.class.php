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
 
 class PFAView {
	var $instance;
	var $view;
	
	function __consturct() {
		if(is_file(ROOT . DS . 'view'  . DS . $cPath['class']. '_view.php')) {
			require_once();
			
		}
	}
	function getInstance () {
		if $this->instance == NULL {
			$this->instance = new PFAView();
		}
		return $this->instance;
	}
	function getView () {
	return $this->view
	}
	function setView () {}
	function display() {
		return 0;
	}
	function
	
 
 }
 /* vim: set expandtab softtabstop=4 tabstop=4 shiftwidth=4: */