<?php

  namespace Gambot\Rulesets;
  use \Gambot\BaseMessage;
  
  class SenderExactMatchRuleset extends \Gambot\Rulesets\BaseRuleset {
    protected $_sender;

    public function __construct($attributes) {
      parent::__construct($attributes);

      $this->_sender = $attributes['sender'] ?? [];
    }

    public function matchMessage(BaseMessage $message) {
      if($this->_sender === $message->sender)
        return true;

      return false;
    }
  }