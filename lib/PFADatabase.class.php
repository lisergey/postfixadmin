<?php


abstract class PFADatabase {

  public $type = 'mysql'; //'mysql' or 'mysqli'
  public $host = 'localhost'; //hostname e.g. 'localhost' 
  public $user; //username e.g. 'api'
  public $password; //password for user
  public $database; //the selected database
  /**
	 * Instance of class Database
	 */
	static private $instance = null;
  
  protected $ctx = null; //Active Connection
  
  function __construct() 
  {
    $this->type = PFAConf::read('db_type');
    $this->database = PFAConf::read('db_name');
    $this->user = PFAConf::read('db_user');
    $this->password = PFAConf::read('db_pass');
    $this->host = PFAConf::read('db_host');
  }
  function __destruct()
  {
    //mysql_close($this->ctx);
  }
  static function getInstance()
	{
		if (self::$instance instanceof Database === false) 
		{
      
      $class = 'PFADatabase_'.PFAConf::read('db_type');
			self::$instance = new $class();
		}
		return self::$instance;
	}

  function query ($sql) {  }
}