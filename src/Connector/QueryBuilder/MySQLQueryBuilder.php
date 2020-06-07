<?php
declare(strict_types = 1);

namespace ORMY\Connector\QueryBuilder;

/**
 * QueryBuilder
 */
class MySQLQueryBuilder extends AbstaractQueryBuilder implements QueryBuilderInterface
{
    /**
     * @param string $table
     * @param array  $fields
     *
     * @return QueryBuilderInterface
     */
    public function select(string $table, array $fields): QueryBuilderInterface
    {
        $this->reset();
        $this->query->base = "SELECT ".implode(", ", $fields)." FROM ".$table;
        $this->query->type = 'select';

        return $this;
    }

    /**
     * @param string $table
     *
     * @param array  $fields
     * @param array  $values
     *
     * @return QueryBuilderInterface
     */
    public function insert(string $table, array $fields, array $values): QueryBuilderInterface
    {
        $this->reset();
        $this->query->base = "INSERT INTO ".$table.'('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';
        $this->query->type = 'insert';

        return $this;
    }

    /**
     * @param string $table
     *
     * @return QueryBuilderInterface
     */
    public function delete(string $table): QueryBuilderInterface
    {
        $this->reset();
        $this->query->base = "DELETE FROM ".$table;
        $this->query->type = 'delete';

        return $this;
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $operator
     *
     * @return QueryBuilderInterface
     */
    public function where(string $field, string $value, string $operator = '='): QueryBuilderInterface
    {
        if (in_array($this->query->type, ['select', 'update', 'delete'])) {
            $this->query->where[] = "$field $operator '$value'";
        }

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return QueryBuilderInterface
     */
    public function limit(int $limit): QueryBuilderInterface
    {
        if (in_array($this->query->type, ['select', 'delete'])) {
            $this->query->limit = " LIMIT ".$limit;
        }

        return $this;
    }

    /**
     * @param string $column
     * @param string $orderType
     *
     * @return QueryBuilderInterface
     */
    public function order(string $column, string $orderType = 'ASC'): QueryBuilderInterface
    {
        if (!isset($this->query->limit) && in_array($this->query->type, ['select', 'delete'])) {
            $this->query->order = " ORDER BY ".$column." $orderType";
        }

        return $this;
    }
}
