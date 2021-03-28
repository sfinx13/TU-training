<?php

namespace Core\Component\ORM;

use Core\Component\ORM\DatabaseStorageInterface;
use Core\Component\ORM\EntityInterface;
use PDO;

abstract class AbstractDataMapper 
{
    protected $databaseStorage;

    protected $table;

    protected $entity;

    public function __construct(DatabaseStorageInterface $databaseStorage)
    {
        $this->databaseStorage = $databaseStorage;
    }

    public function findById(int $id): ?EntityInterface
    {
        $this->databaseStorage->select($this->table, [[
            'column' => 'id',
            'value' => $id,
            'operator' => '='
        ]]);

        $row = $this->databaseStorage->fetch();

        if (!empty($row)) {
            return $this->createEntity($row);
        }

        return null;

    }

    public function findAll(array $criteria = []): array
    {
        $this->databaseStorage->select($this->table, $criteria);

        return $this->databaseStorage->fetchAll(
            null !== $this->entity ? \PDO::FETCH_CLASS : \PDO::FETCH_ASSOC , 
            $this->entity);

    }

    abstract protected function createEntity(array $row): ?EntityInterface;

}