<?php
declare(strict_types = 1);

namespace ORMY\App;

use ORMY\Connector\IConnector;
use ORMY\Meneger\Meneger;
use ORMY\Migrator\IMigrator;

/**
 * IOrmy
 */
interface IOrmy
{
    /**
     * Получить Meneger
     *
     * @return Meneger
     */
    public function getMeneger(): Meneger;

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
