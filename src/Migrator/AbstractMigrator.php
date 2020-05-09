<?php
declare(strict_types = 1);

namespace ORMY\Migrator;

use ORMY\Connector\IConnector;
use ORMY\Exceptions\FileNotFoundException;

/**
 * AbstractMigrator
 */
abstract class AbstractMigrator implements IMigrator
{
    /**
     * @var IConnector
     */
    protected IConnector $connector;

    /**
     * @var string
     */
    protected string $migrationDir;

    /**
     * @var string
     */
    protected string $migrationNameSpace;

    /**
     * @var string
     */
    protected string $versionTableName;

    /**
     * Конструктор.
     *
     * @param IConnector $connector
     * @param string     $migrationDir
     * @param string     $migrationNameSpace
     * @param string     $versionTableName
     */
    public function __construct(
        IConnector $connector,
        string $migrationDir,
        string $migrationNameSpace,
        string $versionTableName
    ) {
        $this->connector          = $connector;
        $this->migrationDir       = $migrationDir;
        $this->migrationNameSpace = $migrationNameSpace;
        $DBName                   = $this->connector->getDBName();
        $this->versionTableName   = "`$DBName`".'.'."`$versionTableName`";
    }

    /**
     * Method makes migration ->
     * adds new migration class
     *
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return void
     * @throws FileNotFoundException
     */
    abstract public function makeMigration(string $sqlQueryUp,string $sqlQueryDown = ''): void;

    /**
     * Method calls up methods in new migrations
     * and writes to db new executed version
     *
     * @return bool
     */
    abstract public function migrateUp(): bool;

    /**
     * Method calls all down methods in migrations
     * and deletes all executed versions from db
     *
     * @return bool
     */
    abstract public function migrateDown(): bool;
}