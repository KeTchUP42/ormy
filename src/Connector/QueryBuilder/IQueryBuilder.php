<?php
declare(strict_types = 1);

namespace ORMY\Connector\QueryBuilder;

use PDO;

/**
 * IQueryBuilder
 */
interface IQueryBuilder
{
    /**
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
     * @param string $table
     *
     * @return IQueryBuilder
     */
    public function delete(string $table): IQueryBuilder;

    /**
     * @param string $table
     * @param array  $fields
     *
     * @return IQueryBuilder
     */
    public function select(string $table, array $fields): IQueryBuilder;

    /**
     * @param string $table
     *
     * @param array  $fields
     * @param array  $values
     *
     * @return IQueryBuilder
     */
    public function insert(string $table, array $fields, array $values): IQueryBuilder;

    /**
     * @param string $field
     * @param string $value
     * @param string $operator
     *
     * @return IQueryBuilder
     */
    public function where(string $field, string $value, string $operator = '='): IQueryBuilder;

    /**
     * @param int $limit
     *
     * @return IQueryBuilder
     */
    public function limit(int $limit): IQueryBuilder;

    /**
     * @param string $column
     * @param string $orderType
     *
     * @return IQueryBuilder
     */
    public function order(string $column, string $orderType = 'ASC'): IQueryBuilder;
}
