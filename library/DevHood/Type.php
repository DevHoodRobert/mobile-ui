<?php

namespace DevHood;

class Type extends Object {
    
    protected $_args;
    
    public function __construct( $args = array() ) {
        
        $this->setArgs( $args );
    }
    
    public function setArgs( array $args ) {
        
        $this->_args = $args;
        
        return $this;
    }
    
    public function addArg( $key, $value ) {
        
        $this->_args[ $key ] = $value;
    }
    
    public function getArg( $name, $optValue = null ) {
        
        if( !isset( $this->_args[ $name ] ) && $optValue === null ) {
            
            throw new Exception( "Argument $name was not specified" );
        } else if( isset( $this->_args[ $name ] ) ) {
            
            return $this->_args[ $name ];
        }
        
        return $optValue;
    }
    
    public function setArg( $name, $value ) {
        
        $this->_args[ $name ] = $value;
    }
}