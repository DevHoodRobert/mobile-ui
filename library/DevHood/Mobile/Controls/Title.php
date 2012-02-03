<?php

namespace DevHood\Mobile\Controls;

class Title extends \DevHood\Mobile\Control {
    
    public function handleTagEnd() {
        
        $parent = $this->getParent();
        
        if( $parent instanceof Top ) {
            
            $parent->setArg( '&titlePrinted', true );
            ?><h1><?=$this->getCdata()?></h1><?php
        }
    }
}