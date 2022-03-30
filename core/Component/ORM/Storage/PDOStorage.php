<?php

namespace Core\Component\ORM\Storage;

use Core\Component\ORM\QueryBuilder;
use Core\Component\ORM\DatabaseStorageInterface;

class PDOStorage implements DatabaseStorageInterface
{
    public const TYPE_INTEGER = 'integer';

    private array $config = [];

    private ?\PDO $connection = null;

    private ?\PDOStatement $statement = null;

    private int $fetchMode = \PDO::FETCH_ASSOC;

    public function __construct(string $dsn, string $username = null, string $password = null, array $options = [])
    {
        $this->config['dsn'] = $dsn;
        $this->config['username'] = $username;
        $this->config['password'] = $password;
        $this->config['options'] = $options;
    }

    public function getStatement(): \PDOStatement
    {
        if ($this->statement === null) {
            throw new \PDOException('error statement');
        }

        return $this->statement;
    }

    public function connect(): void
    {
        if ($this->connection) {
            return;
        }

        $this->connection = new \PDO(
            $this->config['dsn'],
            $this->config['username'],
            $this->config['password'],
            $this->config['options']
        );

        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function disconnect(): void
    {
        $this->connection = null;
    }

    public function prepare($sql, array $options = []): self
    {
        $this->connect();
        $this->statement = $this->connection->prepare($sql, $options);
        return $this;
    }

    public function execute(array $parameters): self
    {
        $this->getStatement()->execute($parameters);
        return $this;
    }

    public function fetch(int $fetchMode = null, int $cursorOrientation = null, int $cursorOffset = null): array
    {
        if ($fetchMode === null) {
            $fetchMode = $this->fetchMode;
        }

        return $this->getStatement()->fetch($fetchMode, $cursorOrientation, $cursorOffset);
    }

    public function fetchAll(int $fetchMode = null): array
    {
        if ($fetchMode === null) {
            $fetchMode = $this->fetchMode;
        }

        return $this->getStatement()->fetchAll($fetchMode);
    }

    public function getLastInsertedId($name = null): string
    {
        return $this->connection->lastInsertId($name);
    }

    public function getRowCount(): int
    {
        return $this->statement->rowCount();
    }

    public function setFetchMode(int $fetchMode = \PDO::FETCH_ASSOC): bool
    {
        return $this->getStatement()->setFetchMode($fetchMode);
    }

    public function query(string $statement): \PDOStatement
    {
        $this->connect();
        return $this->connection->query($statement);
    }

    public function select(string $table, array $criteria)
    {
        $queryBuilder = (new QueryBuilder())->select()->from($table);

        if (!empty($criteria)) {
            $sql = $queryBuilder->where($criteria)->getQuery();
        } else {
            $sql = $queryBuilder->getQuery();
        }

        return $this->prepare($sql)->execute($queryBuilder->getParameters());
    }

    public function insert(string $table, array $criteria)
    {
        $queryBuilder = (new QueryBuilder())
            ->insert()
            ->into($table)
            ->columns($criteria)
            ->values($criteria);

        return $this->prepare($queryBuilder->getQuery())
            ->execute($queryBuilder->getParameters())
            ->getLastInsertedId();
    }

    public function update(string $table, array $sets, array $criteria = [])
    {
        if (empty($sets)) {
            return null;
        }

        $queryBuilder = (new QueryBuilder())->update($table)->set($sets);

        if (!empty($criteria)) {
            $queryBuilder->where($criteria);
        }

        return $this
            ->prepare($queryBuilder->getQuery())
            ->execute($queryBuilder->getParameters())
            ->getRowCount();
    }

    public function delete(string $table, array $criteria = [])
    {
        if (empty($criteria)) {
            return null;
        }

        $queryBuilder = new QueryBuilder();
        $sql = $queryBuilder
            ->delete()->from($table)
            ->where($criteria)->getQuery();

        return $this->prepare($sql)->execute($queryBuilder->getParameters())->getRowCount();
    }
}
