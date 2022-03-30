<?php

namespace Core\Component\ORM;

use Core\Component\ORM\NameConverter\FieldToCamelCaseStringConverter;
use Core\Component\ORM\Comparator\ObjectComparator;

abstract class AbstractDataMapper
{
    protected $databaseStorage;

    protected $entity;

    protected $originalEntity;

    public function __construct(DatabaseStorageInterface $databaseStorage)
    {
        $this->databaseStorage = $databaseStorage;
    }

    public function findById(int $id): ?EntityInterface
    {
        $this->databaseStorage->select($this->getTable(), ['id' => $id]);

        $row = $this->databaseStorage->fetch();

        if (!empty($row)) {
            $this->originalEntity = clone $this->createEntity($row);
            return $this->createEntity($row);
        }

        return null;
    }

    public function findAll(array $criteria = []): ?array
    {
        $this->databaseStorage->select($this->getTable(), $criteria);

        $collection = [];
        $rows = $this->databaseStorage->fetchAll();
        if (empty($rows)) {
            return null;
        }

        foreach ($rows as $row) {
            $collection[] = $this->createEntity($row);
        }

        return $collection;
    }

    public function save(EntityInterface $entity)
    {
        if (null !== $this->originalEntity) {
            $valueChanges = ObjectComparator::diff($this->originalEntity, $entity);
            if (!empty($valueChanges)) {
                return $this->update($entity, $valueChanges);
            }
            return $this->entity;
        }

        return $this->insert($entity);
    }

    public function delete(EntityInterface $entity)
    {
        return $this->databaseStorage->delete($this->getTable(), ['id' => $entity->getId()]);
    }

    private function insert(EntityInterface $entity)
    {
        $properties = (new \ReflectionObject($entity))->getProperties();
        $criteria = [];
        foreach ($properties as $property) {
            $property->setAccessible(true);
            if ($property->getName() !== EntityInterface::FIELD_ID) {
                $criteria[FieldToCamelCaseStringConverter::normalize($property->getName())] = $property->getValue($entity);
            }
        }

        return $this->databaseStorage->insert($this->getTable(), $criteria);
    }

    private function update(EntityInterface $entity, $valuesChanges)
    {
        $sets = [];

        foreach ($valuesChanges as $column => $valueChange) {
            $sets[FieldToCamelCaseStringConverter::normalize($column)] = $valueChange['new_value'];
        }

        return $this->databaseStorage->update($this->getTable(), $sets, ['id' => $entity->getId()]);
    }

    private function getTable(): string
    {
        $parts = explode("\\", $this->entity);

        return strtolower(end($parts));
    }

    abstract protected function createEntity(array $row): ?EntityInterface;
}
