<?php
declare(strict_types = 1);

namespace ORMY\Connector;

use ORMY\Connector\QueryBuilder\IQueryBuilder;
use ORMY\Connector\QueryBuilder\QueryBuilder;
use ORMY\Connector\source\AbstractConnector;
use PDO;

/**
 * ORM Connector
 */
class Connector extends AbstractConnector
{
    /**
     *
     * @param string $sqlquery
     *
     * @return array
     */
    public function queryAll(string $sqlquery): array
    {
        return $this->pdo->query($sqlquery)->fetchAll();
    }

    /**
     *
     * @param string $sqlquery
     * @param int    $style
     *
     * @return array
     */
    public function query(string $sqlquery, int $style = PDO::FETCH_BOTH): array
    {
        return $this->pdo->query($sqlquery)->fetch($style);
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
