<?php

namespace DevHood;

class App extends Object implements \ArrayAccess {
    
    protected $_appPath;
    protected $_loader;
    protected $_registry;
    protected $_debugStack;
    protected $_exceptionHandler;
    
    public function __construct( $appPath, Loader $loader = null ) {
        
        $this->setAppPath( $appPath );
        $this->setDebugStack( array() );
        
        
        if( $loader ) {
            
            $this->setLoader( $loader );
        }
        
        $eh = new ExceptionHandler();
        $eh->enable();
        $this->setExceptionHandler( $eh );
        
        //TRIGGER: construct
        $this->trigger( 'construct' );
    }
    
    private function setRegistry() {}
    private function getRegistry() {}
    
    public function registryGet( $key ) {
        
        if( !isset( $this->_registry[ $key ] ) ) {
            
            return new RegistryException( "Failed to get key $key: Key is not set" );
        }
        
        return $this->_registry[ $key ];
    }
    
    public function registrySet( $key, $value ) {
        
        $this->_registry[ $key ] = $value;
        
        return $this;
    }
    
    public function offsetExists( $key ) {
        
        return isset( $this->_registry[ $key ] );
    }

    public function offsetGet( $key ) {
        
        return $this->registryGet( $key );
    }

    public function offsetSet( $key, $value ) {
        
        $this->registrySet( $key, $value );
        
        return $this;
    }

    public function offsetUnset( $key ) {
        
        unset( $this->_registry[ $key ] );
    }
        
    public function run( $request ) {
        
        //TRIGGER: run
        $this->trigger( 'run' );
        
        //TODO: Maybe implement MVC system for non-mobile apps
        throw new NotImplementedException( "No MVC logic available yet" );
        
        return $this;
    }
    
    public function debug( $key, $var ) {
        
        $this->_debugStack[ $key ] = $var;
        
        return $this;
    }
    
    public function printDebugStack() {
        
        if( empty( $this->_debugStack ) ) {
            
            return;
        }
        
        echo '<pre><b>Debug Stack:</b><br>';
        foreach( $this->_debugStack as $key => $val ) {
            echo $key.': ('.strtoupper( gettype( $val ) ).') '.strval( $val ).'<br>';
        }
        echo '</pre>';
        
        return $this;
    }
    
    public function printDebugStackAfterShutdown() {
        
        register_shutdown_function( array( $this, 'printDebugStack' ) );
        
        return $this;
    }
}