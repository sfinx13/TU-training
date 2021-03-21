<?php 

namespace Core\ORM;

use PDO;
use PDOException;
use RuntimeException;

class MySQLStorage implements DatabaseStorageInterface 
{
    private $config = [];

    private $connection;

    private $statement;

    private $fetchMode = PDO::FETCH_ASSOC;

    public function __construct(string $dsn, string $username, string $password, array $options = [])
    {
        $this->config['dsn'] = $dsn;
        $this->config['username'] = $username;
        $this->config['password'] = $password;
        $this->config['options'] = $options;
    }

    public function getStatement() 
    {
        if($this->statement === null) {
            throw new PDOException('error statement');
        }

        return $this->statement;
    }

    public function connect(): void 
    {
        if ($this->connection) {
            return;
        }

        try {
            $this->connection = new PDO($this->config['dsn'], 
            $this->config['username'], 
            $this->config['password'],
            $this->config['options']);

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            throw new PDOException($exception->getMessage());
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
        
        } catch(PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    public function execute(array $parameters): self
    {
        try {
            $this->getStatement()->execute($parameters);
        
            return $this;

        } catch(PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    public function fetch(int $fetchMode , $cursorOrientation = null, $cursorOffset = null) 
    {
        if($fetchMode === null) {
            $fetchMode = $this->fetchMode;
        }

        try {
            return $this->getStatement()->fetch($fetchMode, $cursorOrientation, $cursorOffset);
        } catch(PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    public function fetchAll(int $fetchMode)
    {
        if($fetchMode === null) {
            $fetchMode = $this->fetchMode;
        }

        try {
            return $this->getStatement()->fetchMode($fetchMode);
        } catch(PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    public function getLastInsertedId($name = null) 
    {
        $this->connect();
        return $this->connection->lastInsertedId($name);
    }

}
