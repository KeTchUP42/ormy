<?php
declare(strict_types = 1);

namespace ORMY\Migrator\source;

use ORMY\Connector\IConnector;

/**
 * AbstractMigrator - source class fir migrator
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
    protected string $migrationsDir;

    /**
     * @var string
     */
    protected string $migrationVersionTableName;

    /**
     * Конструктор.
     *
     * @param IConnector $connector
     * @param string     $migrDir
     * @param string     $migrationVersionTableName
     */
    public function __construct(
        IConnector $connector,
        string $migrDir,
        string $migrationVersionTableName = 'migration_versions'
    ) {
        $this->connector                 = $connector;
        $this->migrationsDir             = $migrDir;
        $this->migrationVersionTableName = $this->connector->getProperty('dbname') . '.' . $migrationVersionTableName;
    }

    /**
     * method maker migration
     * writes to db new ver
     * add new migration class
     *
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return bool
     */
    abstract public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): bool;

    /**
     * method migrateUp
     *
     * @return bool
     */
    abstract public function migrateUp(): bool;

    /**
     * method  migrateDown
     *
     * @return bool
     */
    abstract public function migrateDown(): bool;
}
