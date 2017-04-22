<?php

  namespace Gambot\Rules;
  use \Gambot\BaseMessage;
  
  class BaseRule {

    public static function matchMessage(BaseMessage $message, Array $config) {
      return true;
    }
  }