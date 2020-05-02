<?php
declare(strict_types = 1);

namespace ORMY\Traits;

use ORMY\Connector\source\IConnector;

/**
 * ConnectorTrait
 */
trait ConnectorTrait
{
    /**
     * @var IConnector
     */
    protected IConnector $connector;

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
