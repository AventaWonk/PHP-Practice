<?php
  /**
  * SQL generator for PDO
  */
  class SQLGenerator
  {
    const INSERT = "INSERT INTO %s %s VALUES %s";
    const SELECT = "SELECT %s FROM %s WHERE %s";
    const SELECT_ALL = "SELECT %s from %s";
    const UPDATE = "UPDATE % SET % WHERE %";
    const DELETE = "DELETE FROM % WHERE %";

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
            $whereString .= " AND " . $args[$i] . " = :" . $args[$i];
          }
        }
        $i++;
      }

      return [
        "query" => sprintf(self::SELECT, $params, $model->getTableName(), $whereString),
        "availibleParams" => $availibleParams,
      ];
    }

     protected static function generateUpdate($model) {
      // $availibleParams = [];
      // $whereString = "";

      // $i = 0;
      // foreach ($model as $key => $name) {
      //   if($i == 0) {
      //     $params = $key;
      //     $whereString = $key . " = :" . $key;
      //     if($name) {
      //       $availibleParams[$key] = $name;
      //       $whereString = $key . " = :" . $key;
      //     }
      //   } else {
      //     $params .= ", " . $key;
      //     if($name) {
      //       $availibleParams[$key] = $name;
      //       $whereString .= " AND " . $args[$i] . " = :" . $args[$i];
      //     }
      //   }
      //   $i++;
      // }

      // return [
      //   "query" => sprintf(self::SELECT, $params, $model->getTableName(), $whereString),
      //   "availibleParams" => $availibleParams,
      // ];
    }

    public static function generateQuery($query, $model) {

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
          return self::generateUpdate($model);
          break;

        case self::DELETE:
          return self::generateDelete($model);
          break;
      }
    }
  }