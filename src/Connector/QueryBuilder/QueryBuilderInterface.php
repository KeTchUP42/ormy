<?php
declare(strict_types = 1);

namespace ORMY\Connector\QueryBuilder;

use PDO;

/**
 * QueryBuilderInterface
 */
interface QueryBuilderInterface
{
    /**
     * Method builds sql query
     *
     * @return string
     */
    public function getSQL(): string;

    /**
     * Method calls connector's exec method
     *
     * @return bool
     */
    public function exec(): bool;

    /**
     * Method calls connector's query method
     *
     * @param int $fetchStyle
     *
     * @return array
     */
    public function query(int $fetchStyle = PDO::FETCH_ASSOC): array;

    /**
     * Delete operation
     *
     * @param string $table
     *
     * @return QueryBuilderInterface
     */
    public function delete(string $table): QueryBuilderInterface;

    /**
     * Select operation
     *
     * @param string $table
     * @param array  $fields
     *
     * @return QueryBuilderInterface
     */
    public function select(string $table, array $fields): QueryBuilderInterface;

    /**
     * Insert operation
     *
     * @param string $table
     *
     * @param array  $fields
     * @param array  $values
     *
     * @return QueryBuilderInterface
     */
    public function insert(string $table, array $fields, array $values): QueryBuilderInterface;

    /**
     * Where operation
     *
     * @param string $field
     * @param string $value
     * @param string $operator
     *
     * @return QueryBuilderInterface
     */
    public function where(string $field, string $value, string $operator = '='): QueryBuilderInterface;

    /**
     * Limit operation
     *
     * @param int $limit
     *
     * @return QueryBuilderInterface
     */
    public function limit(int $limit): QueryBuilderInterface;

    /**
     * Order operation
     *
     * @param string $column
     * @param string $orderType
     *
     * @return QueryBuilderInterface
     */
    public function order(string $column, string $orderType = 'ASC'): QueryBuilderInterface;
}
