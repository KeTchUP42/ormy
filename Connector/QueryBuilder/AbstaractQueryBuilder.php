<?php
declare(strict_types = 1);

namespace ORMY\Connector\QueryBuilder;

use ORMY\Connector\source\IConnector;

/**
 * AbstaractQueryBuilder
 */
abstract class AbstaractQueryBuilder implements IQueryBuilder
{
    /**
     * @var IConnector
     */
    protected IConnector $connector;

    /**
     * @var string
     */
    protected string     $query = '';

    /**
     * Конструктор.
     *
     * @param IConnector $connector
     */
    public function __construct(IConnector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * Установка Query.
     *
     * @param string $query
     *
     * @return IQueryBuilder
     */
    public function setQuery(string $query): IQueryBuilder
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Method calls connector query
     */
    public function query(): \PDOStatement
    {
        return $this->connector->query($this->query . ';');
    }

    /**
     * Method calls connector exec
     */
    public function exec(): int
    {
        return $this->connector->exec($this->query . ';');
    }
}
