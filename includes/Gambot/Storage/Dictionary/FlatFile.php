<?php

  namespace Gambot\Storage\Dictionary;

  class FlatFile extends Dictionary {
    public $filename;

    public function __construct($attributes = []) {
      $this->filename = $attributes['filename'] ?? 'foobar.php';

      $this->load();
    }

    public function save() {
      // TODO: saving
    }

    public function load() {
      if(file_exists($this->filename) && ($filehandle = fopen($this->filename, 'r')) !== null) {
        $this->_values = [];

        while($line = fgets($filehandle)) {
          if(preg_match('/^([a-zA-Z0-9_#:-]+) = "(.+)"$/', $line, $matches)) {
            $this->value_set($matches[0], $matches[1]);
          }
        }
        fclose($filehandle);
      }
      else {
        // TODO: good error handling
        echo "{$this->filename}\n";
        echo (realpath($this->filename) ? "true\n" : "false\n");
        die("problem\n");
      }
    }
  }