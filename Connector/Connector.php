<?php
declare(strict_types = 1);

namespace ORMY\Connector;

use ORMY\Connector\QueryBuilder\IQueryBuilder;
use ORMY\Connector\QueryBuilder\QueryBuilder;
use ORMY\Connector\source\AbstractConnector;

/**
 * ORM Connector
 */
class Connector extends AbstractConnector
{
    /**
     *
     * @param string $sqlquery
     *
     * @return bool|false|int
     */
    public function exec(string $sqlquery)
    {
        try {
            return $this->pdo->exec($sqlquery);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     *
     * @param string $sqlquery
     *
     * @return bool|false|\PDOStatement
     */
    public function query(string $sqlquery)
    {
        try {
            return $this->pdo->query($sqlquery);
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     *
     * @return IQueryBuilder
     */
    public function getQueryBuilder(): IQueryBuilder
    {
        return new QueryBuilder($this);
    }
}
