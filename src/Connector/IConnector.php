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
     * @param int    $fetchStyle
     *
     * @return array
     */
    public function query(string $sqlquery,int $fetchStyle = PDO::FETCH_ASSOC): array;

    /**
     *
     * @param string $sqlquery
     *
     * @return bool|false|int
     */
    public function exec(string $sqlquery);

    /**
     *
     * @param string $sqlquery
     *
     * @return bool|\PDOStatement
     */
    public function prepare(string $sqlquery);

    /**
     * Получить Properties
     *
     * @return array
     */
    public function getProperties(): array;

    /**
     * Получить Properties
     *
     * @param string $name
     *
     * @return bool|mixed
     */
    public function getProperty(string $name);

    /**
     * Получить DBName
     *
     * @return string
     */
    public function getDBName(): string;

    /**
     * Получить Pdo
     *
     * @return PDO
     */
    public function getPdo(): PDO;
}
