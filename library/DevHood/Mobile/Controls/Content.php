<?php

namespace DevHood\Mobile\Controls;

class Content extends \DevHood\Mobile\Control {
    
    public function handleTagStart() {
        
        ?><div data-role="content"><?php
    }
    
    public function handleTagEnd() {
        
        ?></div><?php
    }
}