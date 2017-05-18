<?php
  /**
  * SQL generator for PDO
  */
  class SQLGenerator
  {
    const INSERT = "INSERT INTO %s %s VALUES %s";
    const SELECT = "SELECT %s FROM %s WHERE %s";
    const SELECT_ALL = "SELECT %s from %s";
    const UPDATE = "UPDATE %s SET %s WHERE %s";
    const DELETE = "DELETE FROM %s WHERE %s";

    protected static function generateSelect($model) {
      $availibleParams = [];
      $whereString = "";

      $i = 0;
      foreach ($model as $key => $name) {
        if($i == 0) {
          $params = $key;
          $whereString = $key . " = :" . $key;
          if($name) {
            $availibleParams[$key] = $name;
            $whereString = $key . " = :" . $key;
          }
        } else {
          $params .= ", " . $key;
          if($name) {
            $availibleParams[$key] = $name;
            $whereString .= " AND " . $key . " = :" . $key;
          }
        }
        $i++;
      }

      return [
        "query" => sprintf(self::SELECT, $params, $model->getTableName(), $whereString),
        "availibleParams" => $availibleParams,
      ];
    }

    protected static function generateSelectAll($model) {
      $i = 0;
      $model2 = get_class_vars($model);
      foreach ($model2 as $key => $name) {
        if($i == 0) {
          $columns = $key;
        } else {
          $columns .= ", " . $key;
        }
        $i++;
      }
      return sprintf(self::SELECT_ALL, $columns, mb_convert_case($model, MB_CASE_LOWER) . "s");
    }

     protected static function generateUpdate($newModel, $previousModel) {
      $availibleParams = [];
      $whereString = "";
      $setString = "";

      $i = 0;
      foreach ($previousModel as $key => $name) {
        if($i == 0) {
          $params = $key;
          $whereString = $key . " = '" . $name . "'";
          if($name) {
            $availibleParams[$key] = $name;
            $whereString = $key . " = '" . $name . "'";
          }
        } else {
          $params .= ", " . $key;
          if($name) {
            $availibleParams[$key] = $name . "'";
            $whereString .= " AND " . $key . " = '" . $name . "'";
          }
        }
        $i++;
      }

      $i = 0;
      foreach ($newModel as $key => $name) {
        if($i == 0) {
          // $setString = $key . " = :" . $name;
          if($name) {
            $setString = $key . " = '" . $name . "'";
          }
        } else {
          if($name) {
            $setString .= ", " . $key . " = '" . $name . "'";
          }
        }
        $i++;
      }
      echo sprintf(self::UPDATE, $newModel->getTableName(), $setString, $whereString);
      return [
        "query" => sprintf(self::UPDATE, $newModel->getTableName(), $setString, $whereString),
        "availibleParams" => $availibleParams,
      ];
    }

    public static function generateQuery($query, $model, $previousModel = 0) {

      switch ($query) {
        case self::INSERT:
          return self::generateSelect($model);
          break;
        
        case self::SELECT:
          return self::generateSelect($model);
          break;

        case self::SELECT_ALL:
          return self::generateSelectAll($model);
          break;

        case self::UPDATE:
          return self::generateUpdate($model, $previousModel);
          break;

        case self::DELETE:
          return self::generateDelete($model);
          break;
      }
    }
  }