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
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        $this->query->type = 'select';

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
     * @param int $start
     * @param int $offset
     *
     * @return $this|IQueryBuilder
     */
    public function limit(int $start, int $offset): IQueryBuilder
    {
        if (in_array($this->query->type, ['select'])) {
            $this->query->limit = " LIMIT " . $start . ", " . $offset;
        }

        return $this;
    }
}
