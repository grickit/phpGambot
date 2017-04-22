<?php

  namespace Gambot\Rules;
  use \Gambot\BaseMessage;
  
  class ValueEqualsRule extends BaseRule {

    public static function matchMessage(BaseMessage $message, Array $config) {
      if(!isset($message->tags[$config[1]]))
        return false;

      if($message->tags[$config[1]] == $config[2])
        return true;

      return false;
    }
  }