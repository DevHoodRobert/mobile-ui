<?php

namespace DevHood\Data\SourceTypes;

class Mysql extends \DevHood\Data\SourceType {
    
    protected $_connection;
    
    public function connect() {
        
        $func = $this->getArg( 'persistent', 'false' ) == 'true' ? 'mysql_pconnect' : 'mysql_connect';
        
        $con = $func( 
            $this->getArg( 'host' ), 
            $this->getArg( 'user' ), 
            $this->getArg( 'pass' ) 
        );
        
        mysql_select_db( $this->getArg( 'db' ), $con );
        
        $this->setConnection( $con );
        
        return $this;
    }
    
    public function disconnect() {
        
        if( $this->getArg( 'persistent', 'false' ) != 'true' ) {
            
            mysql_close( $this->_connection );
        }
    }
    
    public function isConnected() {
        
        return $this->_connection ? true : false;
    }
    
    public function query( $query ) {
        
        $args = func_get_args();
        unset( $args[ 0 ] );
        
        if( !$this->isConnected() ) {
            
            $this->connect();
        }
        
        if( count( $args ) > 0 ) {
            
            foreach( $args as $key => $val ) {
                
                $args[ $key ] = mysql_real_escape_string( $val, $this->_connection );
            }
            
            $query = vsprintf( $query, $args );
        }
        
        $result = mysql_query( $query, $this->_connection );
        
        if( !mysql_num_rows( $result ) ) {
            
            mysql_free_result( $result );
            
            return array();
        }
        
        $table = new \DevHood\Data\Table();
        while( $row = mysql_fetch_assoc( $result ) ) {
            
            $table->addRow( new \DevHood\Data\Row( $row ) );
        }
        
        mysql_free_result( $result );
        
        return $table;
    }
}