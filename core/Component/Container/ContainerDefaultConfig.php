<?php

namespace Core\Component\Container;

class ContainerDefaultConfig
{

    public static function services()
    {
        return [
            'core.router' => [
                'class' => \Core\Component\Routing\Router::class,
            ],
            'core.route.resolver' => [
                'class' => \Core\Component\Routing\RouteResolver::class,
            ],
            'core.controller.resolver' => [
                'class' => \Core\Component\Controller\ControllerResolver::class,
            ],
            'core.controller.argument.resolver' => [
                'class' => \Core\Component\Controller\ArgumentResolver::class,
            ],
            'core.event.emitter' => [
                'class' => \Core\Component\EventEmitter\EventEmitter::class,
            ],
            'core.request' => [
                'class' => \Core\Component\Http\Request::class,
                'parameters' => [$_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER],
            ],
            'core.response' => [
                'class' => \Core\Component\Http\Response::class,
            ],
            'core.config.loader' => [
                'class' => \Core\Component\Config\ConfigLoader::class,
            ]
        ];
    }

    public static function mapping()
    {
        return [
            'Core\Component\Http\Interfaces\RequestInterface' => 'core.request',
            'Core\Component\Http\Interfaces\ResponseInterface' => 'core.response',
            'Core\Component\Controller\ControllerResolverInterface' => 'core.controller.resolver',
            'Core\Component\Controller\ArgumentResolverInterface' => 'core.controller.argument.resolver',
            'Core\Component\EventEmitter\EventEmitterInterface' => 'core.event.emitter',
            'Core\Component\Routing\RouterInterface' => 'core.router',
            'Core\Component\Routing\RouteResolverInterface' => 'core.route.resolver',
            'Core\Component\Config\ConfigLoaderInterface' => 'core.config.loader',
        ];
    }

}

