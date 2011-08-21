<?php

abstract class Model {
  public $db;
  public $table;
  
  public $belongsTo = NULL;
  public $hasMany = NULL;
  
  public function __construct() {
    $this->db = Database::getInstance();
  }

  
  public function save() 
  {
    foreach ( $this->data AS $field => $val)
    {
        if (array_search($field, $this->fieldList) !== false)
        {
          $data[$field] = $val;
        } else 
        {
          $joined[$field] = $val;
        }
    
    }
    
    if (!empty($this->id))
    {
      $success = $this->db->update($this->table, $this->id, $data);
          
    } else {
    
      $success = $this->db->insert($this->table, $data);
      $this->id = $this->db->insertId();
    }
    if(!empty($joined) && $success) 
    {
      $this->saveRelated($joined, $this->id);
    }
    return $success;
  }
  public function saveRelated($joined, $id)
  {
    $models = array();
    foreach($joined AS $assoc => $data)
    {
      $model = ucfirst($assoc);
      if (is_array($data)) {
          foreach ($data AS $key => $val) 
          {
            $new = new $model($val);
            if ($new->belongsTo() && isset($new->belongsTo[get_class($this)]) )
            {
              $new->set($new->belongsTo[get_class($this)], $this->id);
            }
            $models[$model][] = $new;
          }
      } elseif(is_object($data))
      {
        $models[$model][] = new $model($data);
      } else
      {
        return false;
      }
      
      foreach($models AS $model => $row)
      {
        foreach( $row AS $ctx) 
        {
          if(!$ctx->save())
          {
            return false;
          }
        }
      
      }
      return true;
      
    }
  }
  
  public function belongsTo()
  {
    ($this->belongsTo != NULL) ? $return = true : $return = false;
    return $return;
  }
  public function set($key, $val)
  {
    $this->data[$key] = $val;
  }
}