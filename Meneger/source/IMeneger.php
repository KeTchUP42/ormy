<?php
declare(strict_types = 1);

namespace ORMY\Meneger\soure;

use ORMY\Connector\source\IConnectorSafe;

/**
 *  IMeneger
 */
interface IMeneger
{
    /**
     *
     * @return IConnectorSafe
     */
    public function getConnector(): IConnectorSafe;
}
