<?php
  include 'sql-generator.php';

  /**
  * Model
  */
  class Model
  {
    private static $lastModel;

    public static function getTableName(){
      return mb_convert_case(get_called_class(), MB_CASE_LOWER) . "s";
    }

    public static function add($model) {
      // $dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root'); 
      // $sth = $dbh->prepare(self::generateSQL($model, self::INSERT));  
      // $sth->execute((array) $model);
      // $dbh = null;
    }

    public static function find($model) {
      $dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root');
      $sql = SQLGenerator::generateQuery(SQLGenerator::SELECT, $model);
      $sth = $dbh->prepare($sql["query"]);
      $sth->execute($sql["availibleParams"]);
      $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, get_called_class());  
      self::$lastModel = $sth->fetch();
      return clone self::$lastModel;
    }

    public static function findSeveral($model) {
      // $rows = [];
      // $dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root');
      // $sth = $dbh->prepare(self::generateSelect($model));  
      // $sth->execute((array) $model);
      // $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, self::getModelName());  
      // while($obj = $sth->fetch()) {  
      //     $rows[] = $obj;  
      // }
      // $dbh = null;
      // return $rows;
    }

    public static function findAll() {
      $model = get_called_class();
      $rows = [];
      $dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root');
      $sth = $dbh->query(SQLGenerator::generateQuery(SQLGenerator::SELECT_ALL, $model));  
      $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $model);  
      while($obj = $sth->fetch()) {  
          $rows[] = $obj;  
      }
      $dbh = null;
      return $rows;
    }

    public function save() {
      if(self::$lastModel){
        $dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root'); 
        $sql = SQLGenerator::generateQuery(SQLGenerator::UPDATE, $this, self::$lastModel);
        $sth = $dbh->query($sql["query"]); 
        // $sth = $dbh->prepare($sql["query"]);  
        // $sth->execute((array) $this);
        $dbh = null;
        
        //echo $sql["query"];
      } else {
        throw new Exception("Error", 1);
      }
    }

    public function delete() {

    }
  }