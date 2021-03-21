<?php
namespace Core\ORM;

interface DatabaseStorageInterface 
{
    public function connect();

    public function disconnect();
    
    /* precompilation de la requete & protection injection sql */
    public function prepare(string $sql, array $options);

    public function execute(array $parameters);

    public function fetch(int $fetchMode, int $cursorOrientation, int $cursorOffset) ;

    public function fetchAll(int $fetchMode); 
}