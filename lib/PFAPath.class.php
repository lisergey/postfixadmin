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
 
 class PFAPath {
 
 
 
  public $cPath = array();
  
  
  function __construct() {
    if(!empty($_GET['q'])) {
      $_GET['q'] = $this->getNormalPath($_GET['q']);
    }else{
      $_GET['q'] = PFAConf::read('home.path', 'home');
    }
    
    $this->path = $_GET['q'];
    $this->build($this->path);
  }
  
  function build($path) {
    $this->aPath = explode('/', $path);
    $path = $this->aPath;
    $class = array_shift($path);
    $method = (!empty($path[0]) ? (!is_numeric($path[0]) ? array_shift($path) : 'view') : 'view');
    $args = $path;
    
    if($this->isAdminPath()) {
      $type = 'admin';
    } elseif ($this->isUserPath()) {
      $type = 'user';
    } else {
      $type = NULL;
    }
    
    $this->cPath = array('class' => $class, 'method' => $method, 'args' => $args, 'type' => $type);
    return $this->cPath;
  }
  
  function getNormalPath($path) {
    if($source = lookupPath($path)) {
      $path = $source;
    }
    
    return $path;
  }
  function lookupPath($path) {
    Config::load('router');
    $this->router = PFAConf::read('route');
  }
  function isAdminPath() {
   return($this->aPath[0] == 'admin');
  }
  function isUserPath() {
    return ($this->aPath[0] == 'user');
  }
 
 }