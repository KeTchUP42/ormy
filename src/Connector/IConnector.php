<?php
declare(strict_types = 1);

namespace ORMY\Connector;

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
     * @return bool|false|\PDOStatement
     */
    public function query(string $sqlquery);

    /**
     *
     * @param string $sqlquery
     *
     * @return bool|false|int
     */
    public function exec(string $sqlquery);

    /**
     * Получить Properties
     *
     * @param string $name
     *
     * @return bool|mixed
     */
    public function getProperty(string $name);

    /**
     * Получить Pdo
     *
     * @return PDO
     */
    public function getPdo(): PDO;
}
