<?php
  include 'sql-generator.php';

  /**
  * Model
  */
  class Model
  {
    private $modelId = null;
    private static $foundModels;

    public static function getTableName() {
      return mb_convert_case(get_called_class(), MB_CASE_LOWER) . "s";
    }

    public static function add($model) {
      $dbh = new PDO(...Settings::get()); 
      $sql = SQLGenerator::generateQuery(SQLGenerator::INSERT, $model);
      $sth = $dbh->prepare($sql["query"]);  
      $sth->execute($sql["params"]);
      $dbh = null;
    }

    public static function find($model) {
      $dbh = new PDO(...Settings::get());
      $sql = SQLGenerator::generateQuery(SQLGenerator::SELECT, $model);
      $sth = $dbh->prepare($sql["query"]);
      $sth->execute($sql["params"]);
      $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, get_called_class());  
      $foundModel = $sth->fetch();
      if($foundModel) {
        $uid = uniqid();
        $foundModel->modelId = $uid;
        self::$foundModels[$uid] = $foundModel;
        $dbh = null;
        return clone $foundModel;
      } else {
        throw new Exception("Has not been found", 1);
      }
    }

    public static function findAll() {
      $model = get_called_class();
      $rows = [];
      $dbh = new PDO(...Settings::get());
      $sql = SQLGenerator::generateQuery(SQLGenerator::SELECT_ALL, $model);
      $sth = $dbh->query($sql["query"]);  
      $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $model);  
      while($obj = $sth->fetch()) {  
          $rows[] = $obj;  
      }
      $dbh = null;
      return $rows;
    }

    public function save() {
      if(self::$foundModels[$this->modelId]) {
        $dbh = new PDO(...Settings::get()); 
        $sql = SQLGenerator::generateQuery(SQLGenerator::UPDATE, $this, self::$foundModels[$this->modelId]);
        $sth = $dbh->prepare($sql["query"]);
        $sth->execute($sql["params"]);
        $dbh = null;
      } else {
        throw new Exception("Model was not found", 1);
      }
    }

    public function delete() {
      $dbh = new PDO(...Settings::get()); 
      $sql = SQLGenerator::generateQuery(SQLGenerator::DELETE, $this);
      $sth = $dbh->prepare($sql["query"]);
      $sth->execute($sql["params"]);
      $dbh = null;
    }
    
   //  function __destruct() {
   //     // if($this->model_id) {
   //     //  unset(self::$foundModels[$this->model_id]);
   //     // }
   // }
  }
