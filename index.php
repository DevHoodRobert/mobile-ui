<?php

require_once './library/DevHood/Loader.php';
use DevHood\Loader,
    DevHood\Mobile\App;

$loader = new Loader( './library' );
$app = new App( './app', $loader );

$app->setBaseUrl( '/mobile-ui' )
    ->printDebugStackAfterShutdown()
    ->run( $_SERVER[ 'REQUEST_URI' ] );