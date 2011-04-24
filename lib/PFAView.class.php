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
	/**
   * @access private
   * @var object instance
   * Singleton-Instanz des FrontControllers
   */
  private static $instance = null;
  
	var $view;
	var $viewInstance;
	
	
	function __consturct($view) {
		$this->setView($view);

	}
	function getInstance () {
		if(self::$instance === null) {
			self::$instance = new PFAView();
		}
        return self::$instance;
	}
	function getView () {
		return $this->view;
	}
	function loadView () {
		if(is_file(ROOT . DS . 'view'  . DS . $this->view. '_view.php')) {
			require_once(ROOT . DS . 'view'  . DS . $this->view. '_view.php');
			$this->viewInstance = new $this->view.'View';

		} elseif (is_file(ROOT . DS . 'plugin'  . DS . $this->view. DS . $this->view.'_view.php')) {
			require_once(ROOT . DS . 'plugin'  . DS . $this->view. DS . $this->view.'_view.php');
			$this->viewInstance = new $this->view.'View';
		}
	}
	function setView ($view) {
		$this->view = $view;
		loadView;
	
	}
	function display() {
		return 0;
	}
	
	
 
 }
 /* vim: set expandtab softtabstop=4 tabstop=4 shiftwidth=4: */