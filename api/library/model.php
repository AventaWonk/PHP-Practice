<?php
  include 'sql-generator.php';

  /**
  * Model
  */
  class Model
  {

    public function getTableName(){
      return mb_convert_case(get_called_class(), MB_CASE_LOWER) . "s";
    }

    public static function add($model) {
      // $dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root'); 
      // $sth = $dbh->prepare(self::generateSQL($model, self::INSERT));  
      // $sth->execute((array) $model);
      // $dbh = null;
    }

    public static function find($model) {
      $tableName = mb_convert_case(get_called_class(), MB_CASE_LOWER) . "s";
      $sql = SQLGenerator::generateQuery(SQLGenerator::SELECT, $model, $tableName);
      $dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root');
      $sth = $dbh->prepare($sql["query"]);
      $sth->execute($sql["availibleParams"]);
      $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, get_called_class());  
      return $sth->fetch();
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
      // $model = self::getModelName();
      // $rows = [];
      // $dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root');
      // $sth = $dbh->query(self::generateSQL(get_class_vars($model), self::SELECT_ALL));  
      // $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $model);  
      // while($obj = $sth->fetch()) {  
      //     $rows[] = $obj;  
      // }
      // $dbh = null;
      // return $rows;
    }

    public function save() {

    }

    public function delete() {

    }
  }