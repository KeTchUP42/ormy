<?php
declare(strict_types = 1);

namespace ORMY\Connector\QueryBuilder;

use ORMY\Traits\ConnectorTrait;
use PDO;

/**
 * AbstaractQueryBuilder
 */
abstract class AbstaractQueryBuilder
{
    use ConnectorTrait;

    /**
     * @var \stdClass
     */
    protected \stdClass  $query;

    /**
     * Method calls connector's exec method
     *
     * @return bool
     */
    public function exec(): bool
    {
        return $this->connector->exec($this->getSQL());
    }

    /**
     * Method builds sql
     *
     * @return string
     */
    public function getSQL(): string
    {
        $query    = $this->query;
        $sqlQuery = $query->base;
        if (!empty($query->where)) {
            $sqlQuery .= " WHERE ".implode(' AND ',$query->where);
        }
        if (isset($query->order)) {
            $sqlQuery .= $query->order;
        }
        if (isset($query->limit)) {
            $sqlQuery .= $query->limit;
        }
        $sqlQuery .= ";";

        return $sqlQuery;
    }

    /**
     * Method calls connector's query method
     *
     * @param int $fetchStyle
     *
     * @return array
     */
    public function query(int $fetchStyle = PDO::FETCH_ASSOC): array
    {
        return $this->connector->query($this->getSQL(),$fetchStyle);
    }

    /**
     * Method resets query
     */
    protected function reset(): void
    {
        $this->query = new \stdClass();
    }
}
