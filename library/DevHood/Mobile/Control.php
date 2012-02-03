<?php

namespace DevHood\Mobile;

abstract class Control extends \DevHood\Type {
    
    protected $_parent;
    protected $_cdata = '';
    protected $_app;
        
    public function setParent( Control $parent ) {
        
        $this->_parent = $parent;
        
        return $this;
    }
    
    public function setApp( App $app ) {
        
        $this->_app = $app;
        
        return $this;
    }
            
    //dummy functions for optional usage in control modules
    public function handleTagStart() {}
    public function handleTagEnd() {}
}