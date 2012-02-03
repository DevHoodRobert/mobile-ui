<?php

namespace DevHood\Mobile\Controls;

class Form extends \DevHood\Mobile\Control {
    
    public function handleTagStart() {
        
        $type = $this->getArg( 'type', 'get' ) == 'get' ? 'get' : 'post';
        $to = $this->getArg( 'to', '#' );
        
        ?><form action="<?=$to?>" method="<?=$type?>"><?php
    }
    
    public function handleTagEnd() {
        
        ?></form><?php
    }
}