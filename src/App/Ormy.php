<?php
declare(strict_types = 1);

namespace ORMY\App;

use ORMY\Connector\Connector;
use ORMY\Meneger\IMeneger;
use ORMY\Meneger\Meneger;
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
     * @param string $dsn
     * @param string $user
     * @param string $pass
     * @param string $migrDir
     */
    public function __construct(
        string $dsn,
        string $user,
        string $pass,
        string $migrDir
    ) {
        $connector      = new Connector($dsn, $user, $pass);
        $this->meneger  = new Meneger($connector);
        $this->migrator = new Migrator($connector, $migrDir);
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
