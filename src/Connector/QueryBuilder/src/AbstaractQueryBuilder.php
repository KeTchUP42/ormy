<?php
declare(strict_types = 1);

namespace ORMY\Connector\QueryBuilder;

use ORMY\Connector\IConnector;

/**
 * AbstaractQueryBuilder
 */
abstract class AbstaractQueryBuilder
{
    /**
     * @var IConnector
     */
    protected IConnector $connector;

    /**
     * @var \stdClass
     */
    protected \stdClass  $query;

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
     * Method calls connector's query
     *
     * @return \PDOStatement
     */
    public function query(): \PDOStatement
    {
        return $this->connector->query($this->getSQL());
    }

    /**
     *
     * @return string
     */
    public function getSQL(): string
    {
        $query = $this->query;
        $sql   = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ";";

        return $sql;
    }

    /**
     * Method calls connector's exec
     *
     * @return bool
     */
    public function exec()
    {
        return $this->connector->exec($this->getSQL());
    }

    /**
     * Method resets query
     */
    protected function reset(): void
    {
        $this->query = new \stdClass();
    }
}
