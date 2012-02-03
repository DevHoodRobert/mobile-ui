<?php

namespace DevHood\Performance;

abstract class CacheType extends \DevHood\Type {
    
    abstract public function set( $key, $value, $lifeTime = 10 );
    abstract public function get( $key );
    abstract public function exists( $key );
    abstract public function remove( $key );
    abstract public function clear();
    
    public function load( $key, $callback, $lifeTime = 10 ) {
        
        if( !is_callable( $callback ) ) {
            //TODO: choose better exception type (CacheException or CacheLoadException maybe?)
            throw new \Exception( "Invalid callback passed to load()" );
        }
        
        if( $this->exists( $key ) ) {
            
            return $this->get( $key );
        }
        
        $result = $callback();
        
        $this->set( $key, $result, $lifeTime );
        
        return $result;
    }
    
    public function passThru( $key, $callback, $lifeTime = 10 ) {
        
        //the difference to load is the fact that this function passes
        //all output directly to the screen (unless buffered again)
        //but with a cache behind it
        
        if( !is_callable( $callback ) ) {
            //TODO: choose better exception type (CacheException or CacheLoadException maybe?)
            throw new \Exception( "Invalid callback passed to passThru()" );
        }
        
        if( $this->exists( $key ) ) {
            
            echo $this->get( $key );
            return;
        }
        
        ob_start();
        $callback();
        $result = ob_get_clean();
        
        $this->set( $key, $result, $lifeTime );
        
        echo $result;
    }
    
    public function __set( $key, $value ) {
        
        $this->set( $key, $value );
    }
    
    public function __isset( $key ) {
        
        return $this->exists( $key );
    }
    
    public function __unset( $key ) {
        
        $this->remove( $key );
    }
    
    public function __get( $key ) {
        
        return $this->get( $key );
    }
}