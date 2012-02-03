<?php
//NOTE: We dont use DevHood\Object here, since it's mostly the first object you
//NOTE: load manually in your project
namespace DevHood;

class Loader {
    
    protected $_isRegistered = false;
    protected $_baseDirectory = './';
    protected $_namespaceSeparators = array( '_', '\\' );
    protected $_fileExtension = '.php';

    public function __construct( $baseDir = null ) {
        
        if( $baseDir !== null ) {
            
            $this->setBaseDirectory( $baseDir );
        }
        
        $this->register();
    }
    
    public function __destruct() {
        
        $this->unregister();
    }
    
    public function setBaseDirectory( $baseDir ) {
        
        $this->_baseDirectory = $baseDir;
        
        if( $this->_baseDirectory[ strlen( $this->_baseDirectory ) - 1 ] != '/' ) {
            
            $this->_baseDirectory .= '/';
        }
        
        return $this;
    }
    
    public function getBaseDirectory() {
        
        return $this->_baseDirectory;
    }
    
    public function addNamespaceSeparator( $separator ) {
        
        $this->_namespaceSeparators[] = $separator;
        
        return $this;
    }
    
    public function setNamespaceSeparators( array $separators ) {
        
        $this->_namespaceSeparators = $separators;
        
        return $this;
    }
    
    public function getNamespaceSeparators() {
        
        return $this->_namespaceSeparators;
    }
    
    public function setFileExtension( $fileExt ) {
        
        $this->_fileExtension = $fileExt;
        
        return $this;
    }
    
    public function getFileExtension() {
        
        return $this->_fileExtension;
    }
    
    public function register() {
        
        spl_autoload_register( array( $this, 'loadFromClassName' ) );
        
        $this->_isRegistered = true;
    }
    
    public function unregister() {
        
        spl_autoload_unregister( array( $this, 'loadFromClassName' ) );
        
        $this->_isRegistered = false;
    }
    
    public function isRegistered() {
        
        return $this->_isRegistered;
    }

    public function loadFromClassName( $className ) {
        
        $path = $this->getBaseDirectory()
              . str_replace( $this->getNamespaceSeparators(), '/', $className )
              . $this->_fileExtension;
        
        include $path; //Supressing errors with @ for include_path to be taken into account while autoloading
        
        return class_exists( $className );
    }
}