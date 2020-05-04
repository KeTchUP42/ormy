<?php
declare(strict_types = 1);

namespace ORMY\Connector\QueryBuilder;

/**
 * IQueryBuilder
 */
interface IQueryBuilder
{
    /**
     *
     * @return int
     */
    public function exec(): int;

    /**
     *
     * @return \PDOStatement
     */
    public function query(): \PDOStatement;

    /**
     *
     * @return string
     */
    public function getSQL(): string;

    /**
     *
     * @param string $table
     * @param array  $fields
     *
     * @return IQueryBuilder
     */
    public function select(string $table, array $fields): IQueryBuilder;

    /**
     *
     * @param string $field
     * @param string $value
     * @param string $operator
     *
     * @return IQueryBuilder
     */
    public function where(string $field, string $value, string $operator = '='): IQueryBuilder;

    /**
     *
     * @param int $start
     * @param int $offset
     *
     * @return IQueryBuilder
     */
    public function limit(int $start, int $offset): IQueryBuilder;
    //TODO add query build methods!

}
