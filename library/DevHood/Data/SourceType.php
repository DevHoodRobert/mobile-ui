<?php

namespace DevHood\Data;

abstract class SourceType extends \DevHood\Type {
    
    abstract public function connect();
    abstract public function disconnect();
    abstract public function isConnected();
    abstract public function query( $query );
}