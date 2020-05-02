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
}
