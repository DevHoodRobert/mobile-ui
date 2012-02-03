<?php

namespace DevHood\Performance\CacheTypes;

class Apc extends \DevHood\Performance\CacheType {
    
    public function set( $key, $value, $lifeTime = 10 ) {
        
        if( is_array( $value ) || is_object( $value ) ) {
            
            $value = serialize( $value );
        }
        
        apc_store( $key, $value, $lifeTime );
        
        return $this;
    }
    
    public function get( $key ) {
        
        $success = false;
        
        $result = apc_fetch( $key, $success );
        
        if( !$success ) {
            //TODO: choose better exception type
            throw new \Exception( "APC cache key $key doesnt exist" );
        }
        
        $unserialized = null;
        
        try {
            
            $unserialized = unserialize( $result );
        } catch( \Exception $e ) {
            
            echo $e->getMessage();
            
            return $result;
        }
        
        return $unserialized;
    }
    
    public function exists( $key ) {
        
        return apc_exists( $key );
    }
    
    public function remove( $key ) {
        
        return apc_delete( $key );
    }
    
    public function clear() {
        
        apc_clear_cache( 'user' );
    }
}