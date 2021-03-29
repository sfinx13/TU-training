<?php

namespace Core\Component\ORM;

use PDOStatement;

class PDOStorage implements DatabaseStorageInterface
{
    private $config = [];

    private $connection;

    private $statement;

    private $fetchMode = \PDO::FETCH_ASSOC;

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

        try {
            $this->connection = new \PDO(
                $this->config['dsn'],
                $this->config['username'],
                $this->config['password'],
                $this->config['options']
            );

            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $exception) {
            throw new \PDOException($exception->getMessage());
        }
    }

    public function disconnect(): void
    {
        $this->connection = null;
    }

    public function prepare($sql, array $options = []): self
    {
        $this->connect();
        try {
            $this->statement = $this->connection->prepare($sql, $options);

            return $this;
        } catch (\PDOException $exception) {
            throw new \PDOException($exception->getMessage());
        }
    }

    public function execute(array $parameters): self
    {
        try {
            $this->getStatement()->execute($parameters);

            return $this;
        } catch (\PDOException $exception) {
            throw new \PDOException($exception->getMessage());
        }
    }

    public function fetch(int $fetchMode = null, int $cursorOrientation = null, int $cursorOffset = null): array
    {
        if ($fetchMode === null) {
            $fetchMode = $this->fetchMode;
        }

        try {
            return $this->getStatement()->fetch($fetchMode, $cursorOrientation, $cursorOffset);
        } catch (\PDOException $exception) {
            throw new \PDOException($exception->getMessage());
        }
    }

    public function fetchAll(int $fetchMode = null, $fetchArgument = null): array
    {
        if ($fetchMode === null) {
            $fetchMode = $this->fetchMode;
        }

        try {
            return $this->getStatement()->fetchAll($fetchMode, $fetchArgument);
        } catch (\PDOException $exception) {
            throw new \PDOException($exception->getMessage());
        }
    }

    public function getLastInsertedId($name = null): string
    {
        $this->connect();
        return $this->connection->lastInsertedId($name);
    }

    /** @TODO for better developer experience create criteriaBuilder class instead of array */
    public function select(string $table, array $criteria, string $operator = "AND")
    {
        $parameters = [];
        $sqlWhereClause = '';

        if (!empty($criteria)) {

            $where = [];
            foreach ($criteria as $criterion) {
                $parameters[':' . $criterion['column']] = $criterion['value'];
                $where[] = $criterion['column'] . $criterion['operator'] . ':' . $criterion['column'];
            }

            $sqlWhereClause = ' WHERE ' . implode(' ' . $operator . ' ', $where);
        }

        return $this
            ->prepare('SELECT * FROM ' . $table . $sqlWhereClause)
            ->execute($parameters);
    }

    public function query(string $statement): PDOStatement
    {
        $this->connect();
        return $this->connection->query($statement);
    }

    public function insert(string $table, array $criteria)
    {
        // @TODO
        return;
    }

    public function update(string $table, array $criteria)
    {
        // @TODO
        return;
    }

    public function save(string $table)
    {
        // @TODO
        return;
    }

    public function delete(string $table)
    {
        // @TODO
        return;
    }

}
