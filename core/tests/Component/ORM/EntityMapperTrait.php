<?php

namespace Core\Tests\Component\ORM;

use Core\Component\ORM\AbstractDataMapper;
use Core\Component\ORM\EntityInterface;

trait EntityMapperTrait
{
    public function getEntityMapper($dbStorage)
    {
        return new class ($dbStorage) extends AbstractDataMapper {
            use RandomUserTrait;

            protected function createEntity(array $row): ?EntityInterface
            {
                return $this->getRandomUser();
            }
        };
    }
}
