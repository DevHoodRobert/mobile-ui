<?php

namespace DevHood\Mobile\Controls;

use \DevHood\Data\Source;

class DataSource extends \DevHood\Mobile\Control {
    
    public function handleTagEnd() {
        
        $app = $this->getApp();
        $id = $this->getArg( 'id' );
        
        //register datasource with this id in app registry (See DevHood\App & ArrayAccess)
        $app[ $id ] = new Source( $this->getArg( 'type', 'mysql' ), $this->getArgs() );
    }
}