<?php
declare(strict_types = 1);

namespace ORMY\App;

use ORMY\Connector\Connector;
use ORMY\Exceptions\ConnectionException;
use ORMY\Meneger\IMeneger;
use ORMY\Meneger\Meneger;
use ORMY\Migrator\Migrator;
use ORMY\Migrator\Source\IMigrator;
use ORMY\Migrator\Source\IMigratorFull;

/**
 * Main ORM class
 */
class Ormy implements IOrmy
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
     * @param string $migrationNameSpace
     *
     * @throws ConnectionException
     */
    public function __construct(
        string $dsn,
        string $user,
        string $pass,
        string $migrationDir,
        string $migrationNameSpace = self::NAMESPACE_AUTO
    ) {
        $connector      = new Connector($dsn, $user, $pass);
        $this->meneger  = new Meneger($connector);
        $this->migrator = new Migrator($connector,
            $migrationDir,
            $this->returnCorrectNameSpace($migrationNameSpace, $migrationDir)
        );
    }

    /**
     * Method generates correct namespace of migrations
     *
     * @param string $nameSpace
     * @param string $migrationDir
     *
     * @return string
     */
    private function returnCorrectNameSpace(string $nameSpace, string $migrationDir): string
    {
        return ($nameSpace === self::NAMESPACE_AUTO) ? basename($migrationDir) : $nameSpace;
    }

    /**
     * Reset Migrator.
     *
     * @param string $migrationDir
     *
     * @param string $migrationNameSpace
     * @param string $migrationVerTableName
     *
     * @return Ormy
     */
    public function resetMigrator(
        string $migrationVerTableName,
        string $migrationDir,
        string $migrationNameSpace = self::NAMESPACE_AUTO
    ): Ormy {
        $this->migrator = new Migrator($this->getMeneger()->getConnector(),
            $migrationDir,
            $this->returnCorrectNameSpace($migrationNameSpace, $migrationDir),
            $migrationVerTableName
        );

        return $this;
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
