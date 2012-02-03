<?php

namespace DevHood;

class Object {
    
    protected $_eventHandlers;
        
    public final function bind( $event, $callback ) {
        
        if( !is_callable( $callback ) ) {
            
            throw new \InvalidArgumentException( "Invalid callback provided for event $event" );
        }
        
        if( !isset( $this->_eventHandlers[ $event ] ) ) {
            
            $this->_eventHandlers[ $event ] = array();
        }
        
        $this->_eventHandlers[ $event ][] = $callback;
        
        return $this;
    }
    
    public final function unbind( $event ) {
        
        unset( $this->_eventHandlers[ $event ] );
        
        return $this;
    }
    
    public final function trigger( $event ) {
        
        if( !isset( $this->_eventHandlers[ $event ] ) ) {
            
            return;
        }
        
        $args = func_get_args();
        //Remove own $event arg to callback $sender arg (this object), all other args are optional on both sides
        $args[ 0 ] = $this;
        
        foreach( $this->_eventHandlers[ $event ] as $callback ) {
            
            call_user_func_array( $callback, $args );
        }
        
        return $this;
    }
    
    public function __call( $method, $args ) {
        
        if( strlen( $method ) > 3 ) {
            
            $str = substr( $method, 0, 3 );
            $var = '_'.lcfirst( substr( $method, 3 ) );
            
            switch( $str ) {
                case 'has':
                    
                    return isset( $this->$var ) && !empty( $this->$var );
                case 'get':
                    
                    if( !isset( $this->$var ) ) {
                        
                        throw new Exception( "Variable $var doesnt exist or is undefined ($method)" );
                    }
                    
                    return $this->$var;
                case 'set':
                    
                    if( !isset( $args[ 0 ] ) ) {
                        
                        throw new Exception( "Missing argument to set $var ($method)" );
                    }
                    
                    $this->$var = $args[ 0 ];
                    
                    return $this;
            }
        }
        
        throw new NotImplementedException( "Method $method doesnt exist" );
    }
    
    public static function __callStatic( $method, $args ) {
        
        if( strlen( $method ) > 3 ) {
            
            $str = substr( $method, 0, 3 );
            $var = '_'.lcfirst( substr( $method, 3 ) );
            
            switch( $str ) {
                case 'has':
                    
                    return isset( static::$$var ) && !empty( static::$$var );
                case 'get':
                    
                    if( !isset( static::$$var ) ) {
                        
                        throw new Exception( "Variable $var doesnt exist ($method)" );
                    }
                    
                    return static::$$var;
                case 'set':
                    
                    if( !isset( $args[ 0 ] ) ) {
                        
                        throw new Exception( "Missing argument to set $var ($method)" );
                    }
                    
                    static::$$var = $args[ 0 ];
                    return;
            }
        }
        
        throw new NotImplementedException( "Method $method doesnt exist" );
    }
}