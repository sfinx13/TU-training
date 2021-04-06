<?php

namespace Core\Component\ORM;

interface DatabaseStorageInterface
{
    public function connect();

    public function disconnect();

    public function prepare(string $sql, array $options);

    public function execute(array $parameters);

    public function fetch(int $fetchMode = null, int $cursorOrientation = null, int $cursorOffset = null);

    public function fetchAll(int $fetchMode = null);

    public function select(string $table, array $criteria);

    public function update(string $table, array $sets, array $criteria = []);

    public function insert(string $table, array $criteria);

    public function delete(string $table, array $criteria);

}
