<?php
declare(strict_types = 1);

namespace ORMY\App;

use ORMY\Connector\IConnector;
use ORMY\Manager\IManager;
use ORMY\Migrator\IMigrator;

/**
 * IOrmy
 */
interface IOrmy
{
    /**
     * Получить Manager
     *
     * @return IManager
     */
    public function getManager(): IManager;

    /**
     * Получить Migrator
     *
     * @return IMigrator
     */
    public function getMigrator(): IMigrator;

    /**
     * @return IConnector
     */
    public function getConnector(): IConnector;
}
