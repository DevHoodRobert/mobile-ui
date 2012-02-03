<?php

namespace DevHood\Data;

class Row extends \DevHood\Object implements \ArrayAccess, \IteratorAggregate, \Countable {
    
    protected $_table;
    protected $_data;
    
    public function __construct( array $data = array() ) {
        
        $this->setData( $data );
    }
    
    public function hasColumn( $col ) {
        
        return isset( $this->_data[ $col ] );
    }
    
    public function getColumn( $col ) {
        
        if( !$this->hasColumn( $col ) ) {
            //TODO: Choose a better exception type
            throw new \Exception( "Invalid column $col" );
        }
        
        return $this->_data[ $col ];
    }
    
    public function setColumn( $col, $value ) {
        
        $this->_data[ $col ] = $value;
        
        return $this;
    }
    
    public function getIterator() {
        
        return new ArrayIterator( $this->_data );
    }
    
    public function count() {
        
        return count( $this->_data );
    }
    
    public function offsetExists( $col ) {
        
        return $this->hasColumn( $col );
    }

    public function offsetGet( $col ) {
        
        return $this->getColumn( $col );
    }

    public function offsetSet( $col, $value ) {
        
        $this->setColumn( $col, $value );
    }

    public function offsetUnset( $col ) {
        
        //TODO: I know this is bad in some table-consistency related way...
        unset( $this->_data[ $col ] );
    }
    
    public function __get( $col ) {
        
        return $this->getColumn( $col );
    }
    
    public function __set( $col, $value ) {
        
        $this->setColumn( $col, $value );
    }
    
}