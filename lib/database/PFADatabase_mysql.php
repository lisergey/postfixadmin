<?php


class PFADatabase_mysql extends PFADatabase {

  /**
  @todo: error on conn fail
  **/
  function __construct() 
  {  
    parent::__construct();
    $this->ctx = mysql_connect($this->host, $this->user, $this->password);
    mysql_select_db($this->database, $this->ctx); 
  }
  function __destruct()
  {
    //mysql_close($this->ctx);
  }

  
  public function query ($sql) {
  $qry = mysql_query($sql, $this->ctx) OR die(mysql_error());
  if (preg_match("/^SELECT/i", trim($sql)))
  {
    $number_rows = mysql_num_rows ($qry);
  } else
  {
    $number_rows = mysql_affected_rows ($this->ctx);
  }
  if ($number_rows != 0) 
    return true;
  return false;
  }
  
  public function insertId()
  {
    return mysql_insert_id($this->ctx);
  }
  
  public function insert ($table, $values) {
    foreach(array_keys($values) as $key) {
        $values[$key] = "'" . $this->escape_string($values[$key]) . "'";
    }
    $sql_values = "(" . implode(",",$this->escape_string(array_keys($values))).") VALUES (".implode(",",$values).")";
    $result = $this->query ("INSERT INTO $table $sql_values");
    return $result;
  }
  public function update( $table, $where, $values) {
    foreach(array_keys($values) as $key) {
        $sql_values[$key] = $this->escape_string($key) . "='" . $this->escape_string($values[$key]) . "'";
    }
    
    $sql="UPDATE $table SET ".implode(",",$sql_values)." WHERE $where";
    $result = $this->query ($sql);
    return $result;
  }
  
  
  public function escape_string ($string)
  {
    if(is_array($string)) {
      $clean = array();
      foreach(array_keys($string) as $row) {
          $clean[$row] = $this->escape_string($string[$row]);  
      }
      return $clean;
    }
    if (get_magic_quotes_gpc ())
    {
        $string = stripslashes($string);
    }
    if (!is_numeric($string))
    {
      $escaped_string = mysql_real_escape_string($string, $this->ctx);
    }
    else
    {
        $escaped_string = $string;
    }
    return $escaped_string;
  }
}