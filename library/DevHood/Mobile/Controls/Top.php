<?php

namespace DevHood\Mobile\Controls;

class Top extends \DevHood\Mobile\Control {
    
    public function handleTagStart() {
        
        ?><div data-role="header"><?php
    }
    
    public function handleTagEnd() {
        
        ?></div><?php
    }
}