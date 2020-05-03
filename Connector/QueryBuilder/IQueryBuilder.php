<?php
declare(strict_types = 1);

namespace ORMY\Connector\QueryBuilder;

/**
 * IQueryBuilder
 */
interface IQueryBuilder
{
    /**
     * Установка Query.
     *
     * @param string $query
     *
     * @return IQueryBuilder
     */
    public function setQuery(string $query): IQueryBuilder;

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
    //TODO add query build methods!

}
