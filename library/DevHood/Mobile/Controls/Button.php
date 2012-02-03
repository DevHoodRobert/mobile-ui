<?php

namespace DevHood\Mobile\Controls;

class Button extends \DevHood\Mobile\Control {
        
    public function handleTagEnd() {
        
        $type = $this->getArg( 'type', 'button' );
        $icon = $this->getArg( 'icon', '' );
        $to = $this->getArg( 'to', '#' );
        $prefetch = $this->getArg( 'prefetch', 'true' );
        $text = $this->getCdata();
        $parent = $this->getParent();
        $classes = array();
        
        if( $parent instanceof Top && $parent->getArg( '&titlePrinted', false ) ) {
            
            $classes[] = 'ui-btn-right';
        }
        
        if( !empty( $icon ) ) {
            
            $icon = " data-icon=\"$icon\"";
        }
        
        if( $prefetch == 'true' ) {
            
            $prefetch = ' data-prefetch';
        } else {
            
            $prefetch = '';
        }
        
        $to = " href=\"$to\"";
        
        if( !empty( $classes ) ) {
            
            $classes = ' class="'.implode( ' ', $classes ).'"';
        } else {
            
            $classes = '';
        }
        
        switch( $type ) {
            default:
            case 'button':
            case 'link':
                ?><a data-role="button"<?=$icon.$prefetch.$to.$classes?>><?=$text?></a><?php
                break;
            case 'back':
                
                if( empty( $icon ) ) {
                    
                    $icon = ' data-icon="back"';
                }
                
                ?><a data-rel="back" data-role="button"<?=$icon.$prefetch.$classes?>><?=$text?></a><?php
                break;
            case 'submit':
            case 'reset':
            case 'image':
                ?><input type="<?=$type?>" value="<?=$text?>"<?=$icon.$classes?>><?php
                
        }
        
        
        
    }
}