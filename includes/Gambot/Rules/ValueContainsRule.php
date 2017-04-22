<?php

  namespace Gambot\Rules;
  use \Gambot\BaseMessage;
  
  class ValueContainsRule extends BaseRule {

    public static function matchMessage(BaseMessage $message, Array $config) {
      if(!isset($message->tags[$config[1]]))
        return false;

      if(strpos($message->tags[$config[1]], $config[2]) !== false)
        return true;

      return false;
    }
  }