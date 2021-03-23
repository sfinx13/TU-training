<?php

/**
 * Events available by default
 *
 *  - core.request
 *  - core.route
 *  - core.controller
 *  - core.argument
 */

$eventEmitter->listen('core.request','App\EventListener\RequestListener::listen');
