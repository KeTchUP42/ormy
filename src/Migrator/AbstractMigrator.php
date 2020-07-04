<?php
declare(strict_types = 1);

namespace ORMY\Migrator;

use ORMY\Connector\ConnectorInterface;
use ORMY\Exceptions\FileNotFoundException;

/**
 * AbstractMigrator
 */
abstract class AbstractMigrator implements MigratorInterface
{
    /**
     * @var ConnectorInterface
     */
    protected ConnectorInterface $connector;

    /**
     * @var string
     */
    protected string $migrationDirectory;

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
     * @param ConnectorInterface $connector
     * @param string             $migrationDirectory
     * @param string             $migrationNameSpace
     * @param string             $versionTableName
     */
    public function __construct(
        ConnectorInterface $connector,
        string $migrationDirectory,
        string $migrationNameSpace,
        string $versionTableName
    ) {
        $this->connector          = $connector;
        $this->migrationDirectory = $migrationDirectory;
        $this->migrationNameSpace = $migrationNameSpace;
        $DBName                   = $this->connector->getDBName();
        $this->versionTableName   = "`$DBName`".'.'."`$versionTableName`";
    }

    /**
     * Method creates new migration and puts it to the migration's dir.
     *
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return void
     * @throws FileNotFoundException
     */
    abstract public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): void;

    /**
     * Method calls `up` method in new migrations and updates version table.
     *
     * @return void
     */
    abstract public function migrateUp(): void;

    /**
     * Method calls `down` method in migrations and deletes all executed versions from db
     *
     * @return void
     */
    abstract public function migrateDown(): void;
}
