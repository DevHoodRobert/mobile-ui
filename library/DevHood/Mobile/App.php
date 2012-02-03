<?php

namespace DevHood\Mobile;

class App extends \DevHood\App {
    
    protected $_baseUrl = '/';
    protected $_defaultFile = 'home.xml';
    protected $_controlNamespace = '\DevHood\Mobile\Controls';
    protected $_currentControl;
    
    private function setCurrentControl() {}
    
    public function run( $request ) {
                        
        $this->debug( 'Request', $request );
        
        $url = preg_replace( '#(^'.$this->getBaseUrl().'|\?.*$)#', '', $request );
        
        if( empty( $url ) || $url == '/' ) {
            
            $url = '/'.$this->getDefaultFile();
        }
        
        $this->debug( 'Url', $url );
        
        if( $url[ 0 ] != '/' ) {
            
            $url = "/$url";
        }
        
        $file = $this->getAppPath().$url;
        
        if( pathinfo( $file, PATHINFO_EXTENSION ) != 'xml' ) {
            
            $file .= '.xml';
        }
        
        
        
        $this->debug( 'File', $file );
        
        $exists = file_exists( $file );
        
        if( !$exists ) {
            
            //TODO: Do some 404 stuff
            $this->debug( 'Status', 'Not found' );
            return $this;
        }
        
        $this->debug( 'Status', 'Found' );
                
        $parser = xml_parser_create();
        
        xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
        xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 );
        
        xml_set_object( $parser, $this );
        xml_set_element_handler( $parser, 'handleTagStart', 'handleTagEnd' );
        xml_set_character_data_handler( $parser, 'handleCdata' );
        
        //parse XML and get output in output buffer
        ob_start();
        $parsed = xml_parse( $parser, file_get_contents( $file ), true );
        $pageContent = ob_get_clean();
        xml_parser_free( $parser );
        
        if( !$parsed ) {
            
            throw new ParserException( $file, $parser );
        }
          
        //TODO: implement caching logic
        echo $pageContent;

        return $this;
    }
    
    public function handleTagStart( $parser, $tagName, $args ) {
        
        $class = $this->getControlNamespace().'\\'.ucfirst( $tagName );
        
        if( !class_exists( $class ) ) {
            
            throw new Exception( "Control &quot;$tagName&quot; is not a valid control (Expected $class to exist)" );
        }
        
        $prevControl = null;
        if( isset( $this->_currentControl ) ) {
            
            $prevControl = $this->_currentControl;
        }
        
        $control = new $class();
        
        if( $prevControl ) {
            
            $control->setParent( $prevControl );
        }
        
        $control->setApp( $this );
        $control->setArgs( $args );
        $control->handleTagStart();
        $this->_currentControl = $control;
    }
    
    public function handleTagEnd( $parser, $tagName ) {
        
        $this->_currentControl->handleTagEnd();
        
        if( $this->_currentControl->hasParent() ) {
            
            //revert current control to parent element 
            //so that further elements get the correct parent
            $this->_currentControl = $this->_currentControl->getParent();
        }
    }
    
    public function handleCdata( $parser, $cdata ) {
                
        if( isset( $this->_currentControl ) && $this->_currentControl instanceof Control ) {
                    
            $this->_currentControl->setCdata( $cdata );
        }
    }
    
    public function invokeControl( $control, array $args = array() ) {
        
        //this method grants the ability to invoke controls out of
        //other controls, even if they are not defined anywhere in the app xml
        
        $class = $this->getControlNamespace().'\\'.ucfirst( $control );
        
        if( !class_exists( $class ) ) {
            
            throw new Exception( "Control &quot;$tagName&quot; is not a valid control (Expected $class to exist)" );
        }
        
        $control = new $class();
        
        $control->setApp( $this );
        $control->setArgs( $args );
        $control->handleTagStart();
        $control->handleTagEnd();
    }
    
    public function __invoke( $control, array $args = array() ) {
        
        $this->invokeControl( $control, $args );
    }
}