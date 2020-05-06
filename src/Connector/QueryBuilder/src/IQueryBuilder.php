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
     * @return string
     */
    public function getSQL(): string;

    /**
     * Method calls connector's exec
     *
     * @return bool
     */
    public function exec();

    /**
     * Method calls connector's query
     *
     * @return \PDOStatement
     */
    public function query(): \PDOStatement;

    /**
     *
     * @param string $table
     *
     * @return $this|IQueryBuilder
     */
    public function delete(string $table): IQueryBuilder;

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
     * @param string $table
     *
     * @param array  $fields
     * @param array  $values
     *
     * @return $this|IQueryBuilder
     */
    public function insert(string $table, array $fields, array $values): IQueryBuilder;

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
     * @param int $limit
     *
     * @return $this|IQueryBuilder
     */
    public function limit(int $limit): IQueryBuilder;
    //TODO add query build methods!

}
