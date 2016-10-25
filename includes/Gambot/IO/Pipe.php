<?php

  namespace Gambot\IO;
  
  class Pipe {
    private $_handle;
    private $_buffer = '';
    
    public function __construct($handle) {
      $this->_handle = $handle;
      stream_set_blocking($this->_handle, FALSE);
    }
    
    public function getLines() {
      // Read as much content from the filehandle as we can
      while(($content = fgets($this->_handle, 20)) != null) {
        $this->_buffer .= $content;
      }

      // If the buffer isn't empty, split it along newlines
      if($this->_buffer !== '') {
        $lines = preg_split("/[\r\n]+/", $this->_buffer);

        // If the buffer ends with partial content (not a clean line end),
        // put the last lines back into the buffer
        if(preg_match("/[\r\n]+$/",$this->_buffer) !== 1) {
          $this->_buffer = array_pop($lines);
        }

        // Otherwise clear the buffer
        else {
          $this->_buffer = '';
          // Special check to discard the last line if it's just an empty string
          if(end($lines) === '') array_pop($lines);
        }

        // Return our lines (if any are left)
        return $lines;
      }

      // Return empty array
      return [];
    }
  }