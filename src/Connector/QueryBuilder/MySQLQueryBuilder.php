<?php
declare(strict_types = 1);

namespace ORMY\Connector\QueryBuilder;

/**
 * QueryBuilder
 */
class MySQLQueryBuilder extends AbstaractQueryBuilder implements QueryBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function select(string $table, array $fields): QueryBuilderInterface
    {
        $this->reset();
        $this->query->base = "SELECT ".implode(", ", $fields)." FROM ".$table;
        $this->query->type = 'select';

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function insert(string $table, array $fields, array $values): QueryBuilderInterface
    {
        $this->reset();
        $this->query->base = "INSERT INTO ".$table.' ('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';
        $this->query->type = 'insert';

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $table): QueryBuilderInterface
    {
        $this->reset();
        $this->query->base = "DELETE FROM ".$table;
        $this->query->type = 'delete';

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function where(string $field, string $value, string $operator = '='): QueryBuilderInterface
    {
        if (in_array($this->query->type, ['select', 'update', 'delete'])) {
            $this->query->where[] = "$field $operator '$value'";
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function limit(int $limit): QueryBuilderInterface
    {
        if (in_array($this->query->type, ['select', 'delete'])) {
            $this->query->limit = " LIMIT ".$limit;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function order(string $column, string $orderType = 'ASC'): QueryBuilderInterface
    {
        if (!isset($this->query->limit) && in_array($this->query->type, ['select', 'delete'])) {
            $this->query->order = " ORDER BY ".$column." $orderType";
        }

        return $this;
    }
}
