<?php

  namespace Gambot\Storage\Dictionary;
  
  // COMMENTS ABOVE METHODS IN THIS ABSTRACT CLASS DENOTE THE
  // EXPECTED BEHAVIOR OF THOSE METHODS IN CLASSES EXTENDING
  // FROM IT.
  //
  // The hope is to implement a variety of storage engines and
  // be able to expect the same behavior from them as far as
  // data manipulation, regardless of where they end up storing
  // their data.
  //
  // The word "returns" denotes expected returned information.
  //
  // This is probably the best anyone can wish for as far as
  // documentation in one of my projects.

  abstract class Dictionary {
    protected $_values = []; 

    // Provides whether a name exists in the dictionary.
    // Returns TRUE if $name exists
    // Returns FALSE otherwise
    public function value_exists($name) {
      return (isset($this->_values[$name]) ? TRUE : FALSE);
    }


    // Returns a comma separated string list of names in this dictionary.
    public function value_list() {
      return implode(', ', array_keys($this->_values));
    }


    // Returns a count of names in the dictionary
    public function value_count() {
      return count($this->_values);
    }


    // Returns the entire value store to be consumed elsewhere.
    public function value_dump() {
      return $this->_values;
    }


    // Creates or updates the value of a name in the dictionary.
    // Sets $name = $value
    // Returns TRUE
    public function value_set($name, $value) {
      $this->_values[$name] = $value;

      return TRUE;
    }


    // Provides the value of a name in the dictionary.
    // Returns FALSE if $name does not exist
    // Returns the value of $name otherwise
    public function value_get($name) {
      if(!$this->value_exists($name)) return FALSE;

      return $this->_values[$name];
    }


    // Removes values from the dictionary.
    // Returns FALSE if $name does not exist
    // Returns the value of $name otherwise
    // Deletes $name
    public function value_delete($name) {
      if(!$this->value_exists($name)) return FALSE;

      $value = $this->value_get($name);
      unset($this->_values[$name]);

      return $value;
    }


    // Only adds new values to the dictionary. Will not overwrite existing values.
    // Returns FALSE if $name exists
    // Sets $name = $value otherwise
    // Returns the value of $name
    public function value_add($name, $value) {
      if($this->value_exists($name)) return FALSE;

      $self->value_set($name, $value);
      return $self->value_get($name);
    }


    // Only overwrites existing values. Will not add new values to the dictionary.
    // Returns FALSE if $name does not exist
    // Sets $name = $value otherwise
    // Returns the value of $name
    public function value_replace($name, $value) {
      if(!$this->value_exists($name)) return FALSE;

      $self->value_set($name, $value);
      return $self->value_get($name);
    }


    // Attempts to type juggle $name to an integer and increment it
    // Sets $name = 0 if $name does not exist
    // Adds $value to (integer)$name
    // Returns $the value of $name
    public function value_increment($name, $value) {
      if(!$this->value_exists($name)) $this->value_set($name, 0);

      $this->value_set($name, (integer)$this->value_get($name) + $value);

      return $this->value_get($name);
    }


    // Attempts to type juggle $name to an integer and decrement it
    // Sets $name = 0 if $name does not exist
    // Subtracts $value from (integer)$name
    // Returns $the value of $name
    public function value_decrement($name, $value) {
      if(!$this->value_exists($name)) $this->value_set($name, 0);

      $this->value_set($name, (integer)$this->value_get($name) - $value);

      return $this->value_get($name);
    }


    // Concatenates the value of $name and $value
    // Sets $name = '' if $name does not exist
    // Sets $name .= $value
    // Returns the value of $name
    public function value_append($name, $value) {
      if(!$this->value_exists($name)) $this->value_set($name, '');

      $this->value_set($name, $this->value_get($name).$value);

      return $this->value_get($name);
    }


    // Concatenates $value and the value of $name
    // Sets $name = '' if $name does not exist
    // Sets $name = $value . value of $name
    // Returns the value of $name
    public function value_prepend($name, $value) {
      if(!$this->value_exists($name)) $this->value_set($name, '');

      $this->value_set($name, $value.$this->value_get($name));

      return $this->value_get($name);
    }

    // Assumes the value of $name is a comma separated string list
    // Returns FALSE if $name does not exist
    // Returns FALSE if $value is already present in the list
    // Adds $value to the list otherwise
    // Returns the value of $name
    //
    // TODO: could be faster using regex check for existance?
    public function value_push($name, $value) {
      if(!$this->value_exists($name)) return FALSE;

      $array = array_flip(explode(',', $this->value_get($name)));

      if(isset($array[$value])) return FALSE;

      $this->value_set($name, $this->value_get($name).",{$value}");

      return $this->value_get($name);
    }

    // Assumes the value of $name is a comma separated string list
    // Returns FALSE if $name does not exist
    // Returns FALSE if $value is not already present in the list
    // Removes $value from the list otherwise
    // Returns the value of $name
    //
    // TODO: could be faster using regex check for existance?
    // TODO: regex replace could be faster for removing $value?
    public function value_pull($name, $value) {
      if(!$this->value_exists($name)) return FALSE;

      $array = array_flip(explode(',', $this->value_get($name)));

      if(!isset($array[$value])) return FALSE;

      unset($array[$value]);

      $this->value_set($name, implode(',', array_keys($array)));

      return $this->value_get($name);
    }
  }