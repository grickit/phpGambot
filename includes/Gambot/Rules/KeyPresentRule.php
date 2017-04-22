<?php

  namespace Gambot\Rules;
  use \Gambot\BaseMessage;
  
  class KeyPresentRule extends BaseRule {

    public static function matchMessage(BaseMessage $message, Array $config) {
      if(isset($message->tags[$config[1]]))
        return true;

      return false;
    }
  }