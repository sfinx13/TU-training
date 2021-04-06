<?php

namespace Core\Component\ORM;

/* @todo handle exception */
class QueryBuilder
{
    const SQL_COMMAND_SELECT = 'SELECT';
    const SQL_COMMAND_INSERT = 'INSERT';
    const SQL_COMMAND_UPDATE = 'UPDATE';
    const SQL_COMMAND_DELETE = 'DELETE';

    private string $command;

    private string $fields;

    private string $from;

    private string $table;

    private string $into;

    private string $columns;

    private string $values;

    private array $where = [];

    private array $parameters = [];

    private array $set = [];

    public function select(array ...$fields)
    {
        if (empty($fields)) {
            $this->command = self::SQL_COMMAND_SELECT;
            $this->fields = ' * ';
        }

        return $this;
    }

    public function delete()
    {
        $this->command = self::SQL_COMMAND_DELETE;
        return $this;
    }

    public function update($table)
    {
        $this->command = self::SQL_COMMAND_UPDATE;
        $this->table = $table;
        return $this;
    }

    public function insert()
    {
        $this->command = self::SQL_COMMAND_INSERT;
        return $this;
    }

    public function from(string $table)
    {
        $this->from = ' FROM ' . $table;
        return $this;
    }

    public function into(string $table)
    {
        $this->into = ' INTO ' . $table. ' ';
        return $this;
    }

    public function set(array $sets)
    {
        foreach ($sets as $column => $value) {
            $this->parameters[$column] = $value;
            $this->set[] = $column . ' = :' . $column;
        }

        return $this;
    }

    public function columns(array $criteria)
    {
        $this->columns = implode("','", array_keys($criteria));
        return $this;
    }

    public function values($criteria)
    {
        $this->values = implode(', :', array_keys($criteria));

        foreach ($criteria as $column => $value) {
            $this->parameters[$column] = $value;
        }

        return $this;
    }

    public function where(array $criteria)
    {
        if (!empty($criteria)) {
            foreach ($criteria as $column => $value) {
                $operator = gettype($value) === PDOStorage::TYPE_INTEGER ? ' = ' : ' LIKE ';
                $this->where[] = $column . $operator . ':' . $column;
                $this->parameters[$column] = $value;
            }
        }

        return $this;
    }

    public function getQuery()
    {
        switch ($this->command) {
            case self::SQL_COMMAND_SELECT:
                return $this->buildSelectQuery();
            case self::SQL_COMMAND_DELETE:
                return $this->buildDeleteQuery();
            case self::SQL_COMMAND_INSERT:
                return $this->buildInsertQuery();
            case self::SQL_COMMAND_UPDATE:
                return $this->buildUpdateQuery();
            default:
                return null;
        }
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    private function buildSelectQuery()
    {
        $sql = $this->command . $this->fields . $this->from;
        $sql .= !empty($this->where) ? ' WHERE ' . implode(' AND ', $this->where) : '';

        return $sql;
    }

    private function buildDeleteQuery()
    {
        $sql = $this->command . $this->from;
        $sql .= !empty($this->where) ? ' WHERE ' . implode(' AND ', $this->where) : '';

        return $sql;
    }

    private function buildInsertQuery()
    {
        return $this->command . " $this->into ('{$this->columns}')  VALUES (:{$this->values})";
    }

    private function buildUpdateQuery()
    {
        return $this->command . ' '. $this->table . ' SET ' . implode(',', $this->set)
            . ' WHERE ' . implode(' AND  ', $this->where);
    }

}