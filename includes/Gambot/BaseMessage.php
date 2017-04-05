<?php

  namespace Gambot;
  
  class BaseMessage {
    public $sender;
    public $body;
    public $type;
    public $tags;

    public function __construct($attributes = []) {
      $this->init($attributes);
    }

    public function init($attributes) {
      if(!isset($attributes['sender']))
        die('Message must have attribute "sender".');

      $this->sender = $attributes['sender'];
      $this->body = $attributes['body'] ?? '';
      $this->type = $attributes['type'] ?? 'message';
      $this->tags = $attributes['tags'] ?? [];
    }

    public function matchTag($key, $value) {
      // fail if we don't have the key
      if(!isset($this->tags[$key]))
        return false;

      // succeed if they don't care about the value
      if($value === '*')
        return true;

      // succeed if the value matches
      if($this->tags[$key] === $value)
        return true;

      // fail by default
      return false;
    }

    // Functions for adding tags
    public function beforeAddTag($key, $value, $overwrite = false) {
      return true;
    }

    public function addTag($key, $value, $overwrite = false) {
      return $this->addTagInternal($key, $value, $overwrite);
    }

    public function afterAddTag($key, $value, $success) {
      return true;
    }

    protected function addTagInternal($key, $value, $overwrite = false) {
      if($this->beforeAddTag($key, $value, $overwrite)) {
        // If not already set or if we are allowed to overwrite
        if(!isset($this->tags[$key]) || $overwrite === true) {
          $this->tags[$key] = $value;
          $this->afterAddTag($key, $value, true);
          return true;
        }
      }

      $this->afterAddTag($key, $value, false);
      return false;
    }

    // Functions for removing tags
    public function beforeRemoveTag($key) {
      return true;
    }

    public function removeTag($key) {
      return $this->removeTagInternal($key);
    }

    public function afterRemoveTag($key, $success) {
      return true;
    }

    protected function removeTagInternal($key) {
      if($this->beforeRemoveTag($key) && isset($this->tags[$key])) {
        unset($this->tags[$key]);
        $this->afterRemoveTag($key, true);
        return true;
      }

      $this->afterRemoveTag($key, false);
      return false;
    }
  }