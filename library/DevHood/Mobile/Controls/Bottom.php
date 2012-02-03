<?php

namespace DevHood\Mobile\Controls;

class Bottom extends \DevHood\Mobile\Control {
    
    public function handleTagStart() {
        
        ?><div data-role="bottom"><?php
    }
    
    public function handleTagEnd() {
        
        ?></div><?php
    }
}