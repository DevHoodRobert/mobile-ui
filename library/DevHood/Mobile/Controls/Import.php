<?php

namespace DevHood\Mobile\Controls;

class Import extends \DevHood\Mobile\Control {
    
    public function handleTagEnd() {
        
        $this->getApp()->run( $this->getArg( 'file' ) );
    }
}