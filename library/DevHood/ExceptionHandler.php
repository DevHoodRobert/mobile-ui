<?php

namespace DevHood;

class ExceptionHandler extends Object {
    
    protected $_isEnabled = false;
    
    protected $_severityMap = array(
        1       => 'E_ERROR',
        2       => 'E_WARNING',
        4       => 'E_PARSE',
        8       => 'E_NOTICE',
        16      => 'E_CORE_ERROR',
        32      => 'E_CORE_WARNING',
        64      => 'E_COMPILE_ERROR',
        128     => 'E_COMPILE_WARNING',
        256     => 'E_USER_ERROR',
        512     => 'E_USER_WARNING',
        1024    => 'E_USER_NOTICE',
        2048    => 'E_STRICT',
        4096    => 'E_RECOVERABLE_ERROR',
        8192    => 'E_DEPRECATED',
        16384   => 'E_USER_DEPRECATED',
        32767   => 'E_ALL'  
    );
    
    public function isEnabled() {
        
        return $this->_isEnabled;
    }
    
    public function enable() {
        
        set_error_handler( function( $severity, $message, $file, $line ) {
            
            $level = error_reporting();
            
            //Dont ignore error reporting, since it's the base for the
            // @-operator to work 
            //(needed in e.g. \DevHood\Loader->loadFromClassName()'s include())
            if( $severity & $level ) {
                
                throw new \ErrorException( $message, 0, $severity, $file, $line );
            }
        } );
        set_exception_handler( array( $this, 'handleException' ) );
        
        $this->_isEnabled = true;
    }
    
    public function disable() {
        
        restore_error_handler();
        restore_exception_handler();
        
        $this->_isEnabled = false;
    }
    
    public function handleException( \Exception $e ) {
        
        $class = get_class( $e );
        
        echo '<pre>';
        echo "<b>Unhandled $class thrown</b><br>";
        
        if( $e instanceof \ErrorException ) {
            
            echo 'Severity: '.$this->getSeverityAsString( $e->getSeverity() ).'<br>';
        }
        
        echo '<br>';
        echo '<b>Message:</b><br>';
        echo '<font color="#777777">'.$e->getMessage().'</font><br>';
        
        echo '<br>';
        echo '<b>Location:</b><br>';
        echo '<font color="#777777">'.$e->getFile().'<br>';
        echo ' on line '.$e->getLine().'</font><br>';
        
        echo '<br>';
        echo '<b>Stacktrace:</b><br>';
        echo '<font color="#777777">'.$e->getTraceAsString().'</font>';
    }
    
    public function getSeverityAsString( $severity ) {
        
        //TODO: Maybe parse the bitmask and return an array of strings (e.g. DevHood\Utils\BitUtil::parseBitmask)
        if( !isset( $this->_severityMap[ $severity ] ) ) {
            
            return 'Unkown';
        }
        
        return $this->_severityMap[ $severity ];
    }
}


