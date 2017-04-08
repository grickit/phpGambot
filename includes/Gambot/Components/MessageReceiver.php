<?php

  namespace Gambot\Components;
  use \Gambot\BaseMessage;

  abstract class MessageReceiver extends \Gambot\Components\MessageSource {
    protected $_rulesets;

    public function __construct($attributes) {
      parent::__construct($attributes);

      $rulesets = $attributes['rulesets'] ?? [];

      foreach($rulesets as $name => $ruleset_config) {
        if(!isset($ruleset_config['class'])) continue;
        
        $this->_rulesets[$name] = new $ruleset_config['class']($ruleset_config);
      }
    }

    public function matchMessage(BaseMessage $message) {
      $matched = false;

      foreach($this->_rulesets as $name => $ruleset) {
        if($ruleset->matchMessage($message))
          $matched = $name;
      }

      return $matched;
    }

    public function handleMessage($rulesetName, BaseMessage $message) {
      if(!isset($this->_rulesets[$rulesetName]))
        die("MessageReceiver asked to use nonexistant ruleset '{$rulesetName}'.");

      $this->_rulesets[$rulesetName]->handleMessage($message);
      return true;
    }
  }