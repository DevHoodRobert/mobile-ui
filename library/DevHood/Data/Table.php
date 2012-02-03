<?php

namespace DevHood\Data;

class Table extends \DevHood\Object implements \ArrayAccess, \IteratorAggregate, \Countable {
    
    protected $_rows;
    protected $_name;
    
    public function __construct( $name = '', array $rows = array() ) {
        
        $this->setName( $name );
        $this->setRows( $rows );
    }
    
    public function addRow( Row $row ) {
        
        $this->_rows[] = $row;
        
        return $this;
    }
    
    public function getRow( $index ) {
        
        return $this->_rows[ $index ];
    }
    
    public function setRow( $index, Row $row ) {
        
        $this->_rows[ $index ] = $row;
        
        return $this;
    }
    
    public function hasRow( $index ) {
        
        return isset( $this->_rows[ $index ] );
    }
    
    public function getIterator() {
        
        return new ArrayIterator( $this->_rows );
    }
    
    public function count() {
        
        return count( $this->_rows );
    }
    
    public function offsetExists( $index ) {
        
        return $this->hasRow( $index );
    }

    public function offsetGet( $index ) {
        
        return $this->getRow( $index );
    }

    public function offsetSet( $index, $value ) {
        
        $this->setRow( $index, $value );
    }

    public function offsetUnset( $index ) {
        
        unset( $this->_rows[ $index ] );
    }
}