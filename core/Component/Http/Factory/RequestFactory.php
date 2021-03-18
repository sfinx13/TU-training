<?php 

namespace Core\Component\Http\Factory;
use Core\Component\Http\Request;

class RequestFactory
{

    public static function create()
    {
        $request = new Request(
            $_GET,
            $_POST,
            [],
            $_COOKIE,
            $_FILES,
            $_SERVER
        );

        return $request;
    }
    

}