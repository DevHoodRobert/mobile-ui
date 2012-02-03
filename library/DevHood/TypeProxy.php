<?php

namespace DevHood;

abstract class TypeProxy extends Object {
    
    protected $_instance;
    protected $_namespace;
    protected $_baseClass;
    
    public function __construct( $type, $args = array() ) {
        
        $thisClass = get_class( $this );
        $thisNs = dirname( $thisClass );
        
        if( !$this->hasNamespace() ) {
            
            $this->setNamespace( $thisNs.'\\Types' );
        }
        
        if( !$this->hasBaseClass() ) {
            
            $this->setBaseClass( $thisNs.'\\Type' );
        }
        
        $class = $this->getNamespace().'\\'.ucfirst( $type );
        
        if( !class_exists( $class ) ) {
            //TODO: Choose a better exception type
            throw new Exception( "Class $class doesnt exist" );
        }
        
        if( !is_subclass_of( $class, $this->getBaseClass() ) ) {
            //TODO: Choose a better exception type
            throw new Exception( "Class $class is not a valid ".$this->getBaseClass() );  
        }
        
        $this->_instance = new $class( $args );
    }
        
    public function __call( $method, $args ) {
        
        //provides the actual proxy functionality
        
        $ret = null;
        
        try {
            
            $ret = parent::__call( $method, $args );
        } catch( NotImplementedException $e ) {
            
            $instance = $this->getInstance();
            
            if( method_exists( $instance, $method ) ) {
                
                return call_user_func_array( array( $instance, $method ), $args );
            }
            
            throw $e;
        }
        
        return $ret;
    }
}