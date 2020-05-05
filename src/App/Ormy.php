<?php
declare(strict_types = 1);

namespace ORMY\App;

use ORMY\Connector\Connector;
use ORMY\Meneger\IMeneger;
use ORMY\Meneger\Meneger;
use ORMY\Migrator\Migrator;
use ORMY\Migrator\Source\IMigrator;
use ORMY\Migrator\Source\IMigratorFull;

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
     * @param string $migrationDir
     */
    public function __construct(
        string $dsn,
        string $user,
        string $pass,
        string $migrationDir
    ) {
        $connector      = new Connector($dsn, $user, $pass);
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
     * Установка Migrator.
     *
     * @param string $migrationDir
     *
     * @param string $migrationVersionTableName
     *
     * @return Ormy
     */
    public function resetMigrator(string $migrationDir, string $migrationVersionTableName): Ormy
    {
        $this->migrator = new Migrator($this->getMeneger()->getConnector(), $migrationDir, $migrationVersionTableName);

        return $this;
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

    /**
     * Получить Migrator
     *
     * @return IMigratorFull
     */
    public function getFullMigrator(): IMigratorFull
    {
        return $this->migrator;
    }
}
