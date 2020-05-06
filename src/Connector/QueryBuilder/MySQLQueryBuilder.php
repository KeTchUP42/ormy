<?php
declare(strict_types = 1);

namespace ORMY\Connector\QueryBuilder;

/**
 * QueryBuilder
 */
class MySQLQueryBuilder extends AbstaractQueryBuilder implements IQueryBuilder
{
    /**
     *
     * @param string $table
     * @param array  $fields
     *
     * @return $this|IQueryBuilder
     */
    public function select(string $table, array $fields): IQueryBuilder
    {
        $this->reset();
        $this->query->base = "SELECT ".implode(", ", $fields)." FROM ".$table;
        $this->query->type = 'select';

        return $this;
    }

    /**
     *
     * @param string $table
     *
     * @param array  $fields
     * @param array  $values
     *
     * @return $this|IQueryBuilder
     */
    public function insert(string $table, array $fields, array $values): IQueryBuilder
    {
        $this->reset();
        $this->query->base = "INSERT INTO ".$table.'('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';
        $this->query->type = 'insert';

        return $this;
    }

    /**
     *
     * @param string $table
     *
     * @return $this|IQueryBuilder
     */
    public function delete(string $table): IQueryBuilder
    {
        $this->reset();
        $this->query->base = "DELETE FROM ".$table;
        $this->query->type = 'delete';

        return $this;
    }

    /**
     *
     * @param string $field
     * @param string $value
     * @param string $operator
     *
     * @return $this|IQueryBuilder
     */
    public function where(string $field, string $value, string $operator = '='): IQueryBuilder
    {
        if (in_array($this->query->type, ['select', 'update', 'delete'])) {
            $this->query->where[] = "$field $operator '$value'";
        }

        return $this;
    }

    /**
     *
     * @param int $limit
     *
     * @return $this|IQueryBuilder
     */
    public function limit(int $limit): IQueryBuilder
    {
        if (in_array($this->query->type, ['select', 'delete'])) {
            $this->query->limit = " LIMIT ".$limit;
        }

        return $this;
    }
}
