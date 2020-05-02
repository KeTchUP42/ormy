<?php
declare(strict_types = 1);

namespace ORMY\Meneger\soure;

use ORMY\Connector\source\IConnectorSafe;

/**
 * AbstactMeneger source class for Meneger
 */
abstract class AbstactMeneger implements IMeneger
{
    /**
     * @var IConnectorSafe
     */
    protected IConnectorSafe $connector;

    /**
     * Конструктор.
     *
     * @param IConnectorSafe $connector
     */
    public function __construct(IConnectorSafe $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @return IConnectorSafe
     */
    public function getConnector(): IConnectorSafe
    {
        return $this->connector;
    }
}
