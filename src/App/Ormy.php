<?php
declare(strict_types = 1);

namespace ORMY\App;

use ORMY\Connector\Connector;
use ORMY\Connector\IConnector;
use ORMY\Exceptions\ConnectionException;
use ORMY\Manager\IManager;
use ORMY\Manager\Manager;
use ORMY\Migrator\IMigrator;
use ORMY\Migrator\Migrator;

/**
 * Main ORM class
 */
final class Ormy
{
    /**
     * @var IManager
     */
    private IManager   $manager;

    /**
     * @var IMigrator
     */
    private IMigrator  $migrator;

    /**
     * @var IConnector
     */
    private IConnector $connector;

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
        string $migrationNameSpace = null
    ) {
        $this->connector = new Connector($dsn, $user, $pass);
        $this->manager   = new Manager($this->connector);
        $this->migrator  = new Migrator(
            $this->connector, $migrationDir, $migrationNameSpace ?? basename($migrationDir));
    }

    /**
     * Получить Manager
     *
     * @return IManager
     */
    public function getManager(): IManager
    {
        return $this->manager;
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
     * Получить Connector
     *
     * @return IConnector
     */
    public function getConnector(): IConnector
    {
        return $this->connector;
    }
}
