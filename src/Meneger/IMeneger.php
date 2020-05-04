<?php
declare(strict_types = 1);

namespace ORMY\Meneger;

use ORMY\Connector\IConnector;

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
     * Method sends new info to db from container
     *
     * @return bool
     */
    public function flush(): bool;
}
