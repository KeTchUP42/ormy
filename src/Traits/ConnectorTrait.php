<?php
declare(strict_types = 1);

namespace ORMY\Traits;

use ORMY\Connector\ConnectorInterface;

/**
 * ConnectorTrait
 */
trait ConnectorTrait
{
    /**
     * @var ConnectorInterface
     */
    protected ConnectorInterface $connector;

    /**
     * Конструктор.
     *
     * @param ConnectorInterface $connector
     */
    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }
}
