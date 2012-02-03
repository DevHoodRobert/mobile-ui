<?php

namespace DevHood\Mobile\Controls;

class Field extends \DevHood\Mobile\Control {
        
    public function handleTagEnd() {
        
        $app = $this->getApp();
        $parent = $this->getParent();
        $type = $this->getArg( 'type', 'text' );
        $id = $this->getArg( 'id' );
        $text = $this->getCdata();
        $placeHolder = $text.':';
        $value = $this->getArg( 'value', '' );
        $name = $id;    
        $id = "_dhFormField_$id";
        
        $dataType = 'get';
        
        if( $parent instanceof Form ) {
            
            $dataType = $parent->getArg( 'type', 'get' ) == 'get' ? 'get' : 'post';
        }
        
        //automatically detect default value
        if( empty( $value ) ) {
            
            //if field has not been accepted yet, try to accept it
            if( !Accept::hasAccepted( $name ) ) {
                
                // try to accept new var
                $app->invokeControl( 'accept', array( 'id' => $name, 'type', $dataType ) );
                
                if( isset( $app[ $name ] ) ) {
                    
                    $value = $app[ $name ];
                }
            }
            
            //check if field exists in app registry
            if( isset( $app[ $name ] ) ) {
                
                //if yes, use it as the input's default value
                $value = $app[ $name ];
            }
        }
        
        switch( $type ) {
            case 'pass':
                $type = 'password';
            case 'text':
            case 'password':
                ?>
                <div data-role="fieldcontain">
                    <label for="<?=$id?>"><?=$placeHolder?></label>
                    <input 
                        type="<?=$type?>" 
                        name="<?=$name?>" 
                        id="<?=$id?>" 
                        value="<?=$value?>" 
                        placeholder="<?=$text?>">
                </div>
                <?php
        }
    }
}