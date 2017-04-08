<?php

  namespace Gambot\Rulesets;
  use \Gambot\BaseMessage;
  
  class TagExactMatchRuleset extends \Gambot\Rulesets\BaseRuleset {
    protected $_tags_to_receive;

    public function __construct($attributes) {
      parent::__construct($attributes);

      $this->_tags_to_receive = $attributes['tags_to_receive'] ?? [];
    }

    public function matchMessage(BaseMessage $message) {
      // shortcut if the handler is receiving all messages
      if(empty($this->_tags_to_receive))
        return true;

      foreach($this->_tags_to_receive as $key => $value) {
        if(!$message->matchTag($key, $value))
          return false;
      }

      return true;
    }
  }