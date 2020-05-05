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
     * method maker migration
     * writes to db new ver
     * add new migration class
     *
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return void
     * @throws FileNotFoundException
     */
    abstract public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): void;

    /**
     * method migrates up
     *
     * @return bool
     */
    abstract public function migrateUp(): bool;

    /**
     * method migrates down
     *
     * @return bool
     */
    abstract public function migrateDown(): bool;

    /**
     * Получить MigrDir
     *
     * @return string
     */
    public function getMigrDir(): string
    {
        return $this->migrDir;
    }

    /**
     * Получить MigrNameSpace
     *
     * @return string
     */
    public function getMigrNameSpace(): string
    {
        return $this->migrNameSpace;
    }

    /**
     * Получить MigrVersionTableName
     *
     * @return string
     */
    public function getMigrVersionTableName(): string
    {
        return $this->migrVersionTableName;
    }
}
