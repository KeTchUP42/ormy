<?php
declare(strict_types = 1);

namespace ORMY\Meneger\soure;

use ORMY\Connector\source\IConnector;

/**
 * IMeneger
 */
interface IMeneger
{
    /**
     *
     * @return IConnector
     */
    public function getConnector(): IConnector;

    /**
     *
     * @param string $classPath
     *
     * @return mixed
     */
    public function getContainer(string $classPath);

    /**
     * Method sends new info from container
     *
     * @return bool
     */
    public function flush(): bool;
}
