<?php

namespace DevHood\Mobile;

class ParserException extends Exception {
    
    public function __construct( $file, $parser ) {
        
        $this->code = xml_get_error_code( $parser );
        $this->message = xml_error_string( $this->code );
        $this->file = $file;
        $this->line = xml_get_current_line_number( $parser );
        
        $this->message .= ' on line '.$this->line.':'.xml_get_current_column_number( $parser );
    }
}