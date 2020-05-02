<?php
declare(strict_types = 1);

namespace ORMY\Connector\source;

use ORMY\Connector\QueryBuilder\IQueryBuilder;
use PDO;

/**
 * IConnector
 */
interface IConnector
{
    /**
     *
     * @return IQueryBuilder
     */
    public function getQueryBuilder(): IQueryBuilder;

    /**
     *
     * @param string $sqlquery
     *
     * @return array
     */
    public function queryAll(string $sqlquery): array;

    /**
     *
     * @param string $sqlquery
     *
     * @param int    $style
     *
     * @return array
     */
    public function query(string $sqlquery, int $style = PDO::FETCH_BOTH): array;

    /**
     * Получить Address
     *
     * @return string
     */
    public function getAddress(): string;

    /**
     * Получить Host
     *
     * @return string
     */
    public function getHost(): string;

    /**
     *
     * @return string
     */
    public function getDBName(): string;
}