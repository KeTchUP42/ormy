<?php
declare(strict_types = 1);

namespace ORMY\App;

use ORMY\Connector\Connector;
use ORMY\Meneger\Meneger;
use ORMY\Meneger\soure\IMeneger;
use ORMY\Migrator\Migrator;
use ORMY\Migrator\source\IMigrator;

/**
 * Main ORM class
 */
class Ormy
{
    /**
     * @var IMeneger
     */
    private IMeneger   $meneger;

    /**
     * @var IMigrator
     */
    private IMigrator  $migrator;

    /**
     * Конструктор.
     *
     * @param string $dbType
     * @param string $address
     * @param string $port
     * @param string $dbName
     * @param string $host
     * @param string $pass
     * @param string $migrationDir
     */
    public function __construct(
        string $dbType,
        string $address,
        string $port,
        string $dbName,
        string $host,
        string $pass,
        string $migrationDir
    ) {

        $connector      = new Connector($dbType, $address, $port, $dbName, $host, $pass);
        $this->meneger  = new Meneger($connector);
        $this->migrator = new Migrator($connector, $migrationDir);
    }

    /**
     * Получить Meneger
     *
     * @return Meneger
     */
    public function getMeneger(): Meneger
    {
        return $this->meneger;
    }

    /**
     * Получить Migrator
     *
     * @return IMigrator
     */
    public function getMigrator(): IMigrator
    {
        return $this->migrator;
    }
}
