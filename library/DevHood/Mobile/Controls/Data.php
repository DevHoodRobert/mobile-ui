<?php

namespace DevHood\Mobile\Controls;

class Data extends \DevHood\Mobile\Control {
    
    public function handleTagEnd() {
        
        $app = $this->getApp();
        $id = $this->getArg( 'id' );
        $source = $this->getArg( 'source' );
        $from = $this->getArg( 'from', 'DEFAULT' );
        $where = $this->getArg( 'where', '' );
        $order = $this->getArg( 'order', '' );
        $limit = $this->getArg( 'limit', '' );
        $fields = $this->getArg( 'fields', '*' );
        $queryArgs = array();
        
        if( !isset( $app[ $source ] ) || !( $app[ $source ] instanceof \DevHood\Data\Source ) ) {
            //TODO: find better exception type
            throw new \Exception( "Data source $source wasn't specified yet" );
        }
        
        if( !empty( $where ) ) {
            
            //TODO: This should be implemented in a global way
            $where = preg_replace_callback( '#{([^}]+)}#', 
                function( $matches ) use( &$app, &$queryArgs ) {
                    
                    $var = $matches[ 1 ];
                    $type = '"%s"';
                    
                    if( !isset( $app[ $var ] ) ) {
                        
                        return $matches[ 0 ];
                    }
                    //TODO: Maybe use switch logic here
                    if( !is_string( $app[ $var ] ) ) {
                        
                        $type = '%d';
                        
                        if( is_float( $app[ $var ] ) ) {
                            
                            $type = '%f';
                        }
                    }
                    
                    $queryArgs[] = $app[ $var ];
                    
                    return $type;
                }, $where 
            );
            
            
            
            $where = " where $where";
        }
        
        if( !empty( $order ) ) {
            
            $order = " order by $order";
        }
        
        if( !empty( $limit ) ) {
            
            $limit = " limit $limit";
        }
                
        $query = "select $fields from $from$where$order$limit";
        
        array_unshift( $queryArgs, $query );
        
        $result = call_user_func_array( array( $app[ $source ], 'query' ), $queryArgs );
        
        $app[ $id ] = $result;
    }
}