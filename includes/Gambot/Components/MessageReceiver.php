<?php

  namespace Gambot\Components;
  use \Gambot\BaseMessage;

  abstract class MessageReceiver extends \Gambot\Components\MessageSource {
    protected $_rulesets;

    public function __construct($attributes) {
      parent::__construct($attributes);

      $this->_rulesets = $attributes['rulesets'] ?? [];
    }

    public function matchMessage(BaseMessage $message) {
      // Start out false.
      // If any rulesets has all of its rules match, this message matches.
      // Consider it that rulesets OR with each other. The rules inside of them AND with each other.
      $message_matched = false;

      foreach($this->_rulesets as $ruleset_index => $ruleset) {
        // Start out true.
        // If any rules within a ruleset are false, this ruleset doesn't match.
        $ruleset_matched = true;
        foreach($ruleset as $rule_index => $rule_config) {
          // Every rule within a ruleset must return true
          if($rule_config[0]::matchMessage($message, $rule_config) !== true) {
            $ruleset_matched = false;
            break;
          }
        }

        // Only one ruleset must be entirely true
        if($ruleset_matched === true) {
          $message_matched = true;
          break;
        }
      }

      return $message_matched;
    }

    public function handleMessage(BaseMessage $message) {
      return true;
    }
  }