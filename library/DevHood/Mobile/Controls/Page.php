<?php

namespace DevHood\Mobile\Controls;

use \DevHood\Mobile\Exception;

class Page extends \DevHood\Mobile\Control {
    
    public function handleTagStart() {
        
        if( $this->hasParent() ) {
            
            throw new Exception( "The page element shouldnt have any parents" );
        }
        
        ?>
        <!doctype html>
        <html lang="<?=$this->getArg( 'lang', 'en' )?>">
        <head> 
            <title>My Page</title> 
            <meta name="viewport" content="width=device-width, initial-scale=1"> 
            <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
            <script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
            <script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
        </head> 
        <body> 
        <div data-role="page" id="<?=$this->getArg( 'id' )?>">

        <?php
    }
    
    public function handleTagEnd() {
        
        ?>
        </div>
        </body>
        </html>
        <?php
    }
}