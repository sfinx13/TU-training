<?php

namespace Core\Tests\Component\ORM;

use Core\Component\ORM\DatabaseStorageInterface;
use PHPUnit\Framework\TestCase;

class AbstractDataMapperTest extends TestCase
{
    use EntityMapperTrait;
    use RandomUserTrait;

    private $dbStorageMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->dbStorageMock = $this->createMock(DatabaseStorageInterface::class);
    }

    public function testFindAll()
    {
        $this->dbStorageMock
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn([]);

        $this->dbStorageMock
            ->expects($this->once())
            ->method('select');

        $dataMapper = $this->getEntityMapper($this->dbStorageMock);

        $dataMapper->findAll();
    }

    public function testFindById()
    {
        $this->dbStorageMock
            ->expects($this->once())
            ->method('fetch')
            ->willReturn([]);

        $this->dbStorageMock
            ->expects($this->once())
            ->method('select');

        $dataMapper = $this->getEntityMapper($this->dbStorageMock);

        $dataMapper->findById(2);
    }

    public function testDelete()
    {
        $this->dbStorageMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn(1);

        $dataMapper = $this->getEntityMapper($this->dbStorageMock);

        $dataMapper->delete($this->getRandomUser());
    }

    public function testSave()
    {
        $this->dbStorageMock
            ->expects($this->once())
            ->method('insert')
            ->willReturn(1);

        $dataMapper = $this->getEntityMapper($this->dbStorageMock);

        $dataMapper->save($this->getRandomUser());
    }
}
