<?php

namespace Core\Component\ORM;

use PDOStatement;

class PDOStorage implements DatabaseStorageInterface
{
    const TYPE_INTEGER = 'integer';

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
        return $this->connection->lastInsertId($name);
    }

    public function getRowCount(): int
    {
        return $this->statement->rowCount();
    }

    public function setFetchMode(int $fetchMode = \PDO::FETCH_ASSOC, string $className = null): bool
    {
        if ($fetchMode === \PDO::FETCH_CLASS && $className === null) {
            throw new \Exception('Please add className parameter');
        }

        return $this->getStatement()->setFetchMode($fetchMode, $className);
    }

    public function select(string $table, array $criteria, string $operator = "AND")
    {
        $parameters = [];
        $sqlWhereClause = '';

        if (!empty($criteria)) {
            $where = [];
            foreach ($criteria as $column => $value) {
                $parameters[$column] = $value;
                $operator = gettype($value) === self::TYPE_INTEGER ? ' = ' : ' LIKE ';
                $where[] = $column . $operator . ':' . $column;
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
        $columns = implode("','", array_keys($criteria));
        $values = implode(', :', array_keys($criteria));

        $parameters = [];

        foreach ($criteria as $column => $value) {
            $parameters[$column] = $value;
        }

        $sql = "INSERT INTO $table ('{$columns}')  VALUES (:{$values})";

        return $this->prepare($sql)->execute($parameters)->getLastInsertedId();
    }

    public function update(string $table, array $sets, array $criteria = [])
    {
        $parameters = [];
        $sqlWhereClause = '';

        if (empty($sets)) {
            return null;
        }

        foreach ($sets as $column => $value) {
            $parameters[$column] = $value;
            $set[] = $column . ' = :' . $column;
        }

        if (!empty($criteria)) {
            foreach ($criteria as $column => $value) {
                $parameters[':' . $column] = $value;
                $operator = gettype($value) === self::TYPE_INTEGER ? ' = ' : ' LIKE ';
                $where[] = $column . $operator . ':' . $column;
            }
            $sqlWhereClause = ' WHERE ' . implode(' ' . $operator . ' ', $where);
        }

        $sql = 'UPDATE ' . $table . ' SET ' . implode(',', $set) . $sqlWhereClause;

        return $this->prepare($sql)->execute($parameters)->getRowCount();
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
