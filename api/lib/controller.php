<?php
namespace general;

/**
* Controller
*/
class Controller
{
  const SUCCESS = true;
  const ERROR = false;

  public function JSON($object, $result = self::SUCCESS)
  {
    switch ($result) {
      case self::SUCCESS:
        $result = ResponseSuccess::get($object);
        break;

      case self::ERROR:
        $result = ResponseError::get($object);
        break;
      
      default:
        $result = ResponseError::get($object);
        break;
    }
    return json_encode($result);
  }

  public function XML($object)
  {
    return new XMLResponse($object);
  }

  public function View($object)
  {
    return new ViewResponse($object);
  }
	
}