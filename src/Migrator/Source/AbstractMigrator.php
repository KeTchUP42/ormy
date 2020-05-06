<?php
declare(strict_types = 1);

namespace ORMY\Migrator\Source;

use ORMY\Connector\IConnector;
use ORMY\Exceptions\FileNotFoundException;

/**
 * AbstractMigrator - Source class fir migrator
 */
abstract class AbstractMigrator implements IMigrator, IMigratorFull
{
    /**
     * @var IConnector
     */
    protected IConnector $connector;

    /**
     * @var string
     */
    protected string $migrDir;

    /**
     * @var string
     */
    protected string $migrNameSpace;

    /**
     * @var string
     */
    protected string $migrVersionTableName;

    /**
     * Конструктор.
     *
     * @param IConnector $connector
     * @param string     $migrDir
     * @param string     $migrNameSpace
     * @param string     $migrVersionTableName
     */
    public function __construct(
        IConnector $connector,
        string $migrDir,
        string $migrNameSpace,
        string $migrVersionTableName
    ) {
        $this->connector            = $connector;
        $this->migrDir              = $migrDir;
        $this->migrNameSpace        = $migrNameSpace;
        $this->migrVersionTableName = $migrVersionTableName;
    }

    /**
     * Получить Migration dir
     *
     * @return string
     */
    public function getMigrationDir(): string
    {
        return $this->migrDir;
    }

    /**
     * Получить Migration namespace
     *
     * @return string
     */
    public function getMigrationNameSpace(): string
    {
        return $this->migrNameSpace;
    }

    /**
     * Получить migration version table name
     *
     * @return string
     */
    public function getMigrationVersionTableName(): string
    {
        return $this->migrVersionTableName;
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
    abstract public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): void;

    /**
     * Method migrates up
     * writes to db new executed version
     *
     * @return bool
     */
    abstract public function migrateUp(): bool;

    /**
     * Method migrates down
     * deletes all executed versions from db
     *
     * @return bool
     */
    abstract public function migrateDown(): bool;
}
