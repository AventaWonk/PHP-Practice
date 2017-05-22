<?php
  include 'sql-generator.php';

  /**
  * Model
  */
  class Model
  {
    private $modelId = null;
    private static $findedModels;

    public static function getTableName() {
      return mb_convert_case(get_called_class(), MB_CASE_LOWER) . "s";
    }

    public static function add($model) {
      $dbh = new PDO(...Settings::get()); 
      $sql = SQLGenerator::generateQuery(SQLGenerator::INSERT, $model);
      $sth = $dbh->prepare($sql["query"]);  
      $sth->execute((array) $sql["availibleParams"]);
      $dbh = null;
    }

    public static function find($model) {
      $dbh = new PDO(...Settings::get());
      $sql = SQLGenerator::generateQuery(SQLGenerator::SELECT, $model);
      $sth = $dbh->prepare($sql["query"]);
      $sth->execute($sql["availibleParams"]);
      $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, get_called_class());  
      $findedModel = $sth->fetch();
      if($findedModel) {
        $uid = uniqid("", true);
        $findedModel->modelId = $uid;
        self::$findedModels[$uid] = $findedModel;
        $dbh = null;
        return clone $findedModel;
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
      if(self::$findedModels[$this->model_id]) {
        $dbh = new PDO(...Settings::get()); 
        self::$lastModel = self::$findedModels[$this->model_id];
        $sql = SQLGenerator::generateQuery(SQLGenerator::UPDATE, $this, self::$lastModel);
        $sth = $dbh->prepare($sql["query"]);
        $sth->execute($sql["availibleParams"]);
        $dbh = null;
      } else {
        throw new Exception("Model was not found", 1);
      }
    }

    public function delete() {
      $dbh = new PDO(...Settings::get()); 
      $sql = SQLGenerator::generateQuery(SQLGenerator::DELETE, $this);
      $sth = $dbh->prepare($sql["query"]);
      $sth->execute($sql["availibleParams"]);
      $dbh = null;
    }
    
   //  function __destruct() {
   //     // if($this->model_id) {
   //     //  unset(self::$findedModels[$this->model_id]);
   //     // }
   // }
  }
