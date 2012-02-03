<?php

namespace DevHood\Mobile\Controls;

class Accept extends \DevHood\Mobile\Control {
        
    protected static $_acceptedVars = array();
    
    public function handleTagEnd() {
        
        $app = $this->getApp();
        $type = $this->getArg( 'type', 'get' ) == 'get' ? 'get' : 'post';
        $id = $this->getArg( 'id' );
        $alias = $this->getArg( 'alias', '' );
        $filter = $this->getArg( 'filter', '' );
        
        $varName = $id;
        $varVal = null;
        
        if( !empty( $alias ) ) {
            
            $varName = $alias;
        }
        
        switch( strtolower( $type ) ) {
            default:
            case 'get':
                
                if( isset( $_GET[ $id ] ) ) {
                    
                    $varVal = $_GET[ $id ];                    
                }
                break;
            case 'post':
                
                if( isset( $_POST[ $id ] ) ) {
                    
                    $varVal = $_POST[ $id ];                    
                }
        }
        
        if( !empty( $filter ) ) {
            
            $varVal = preg_replace( '#[^'.$filter.']#', '', $varVal );
        }
        
        $app[ $varName ] = $varVal;
        
        //we could just put them in that array, but in_array costs more
        //performance than isset( $arr[ $key ] )
        static::$_acceptedVars[ $varName ] = true;
    }
    
    public static function hasAccepted( $key ) {
        
        return isset( static::$_acceptedVars[ $key ] );
    }
}