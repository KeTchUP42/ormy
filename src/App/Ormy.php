<?php
declare(strict_types = 1);

namespace ORMY\App;

use ORMY\Connector\Connector;
use ORMY\Connector\ConnectorInterface;
use ORMY\Exceptions\ConnectionException;
use ORMY\Manager\Manager;
use ORMY\Manager\ManagerInterface;
use ORMY\Migrator\Migrator;
use ORMY\Migrator\MigratorInterface;

/**
 * Main ORM class
 */
final class Ormy
{
    /**
     * @var ManagerInterface
     */
    private ManagerInterface   $manager;

    /**
     * @var MigratorInterface
     */
    private MigratorInterface  $migrator;

    /**
     * @var ConnectorInterface
     */
    private ConnectorInterface $connector;

    /**
     * Конструктор.
     *
     * @param string      $dsn
     * @param string      $user
     * @param string      $pass
     * @param string      $migrationDirectory
     * @param string|null $migrationNameSpace
     *
     * @throws ConnectionException
     */
    public function __construct(
        string $dsn,
        string $user,
        string $pass,
        string $migrationDirectory,
        string $migrationNameSpace = null
    ) {
        $this->connector = new Connector($dsn, $user, $pass);
        $this->migrator  = new Migrator($this->connector, $migrationDirectory, $migrationNameSpace ?? basename($migrationDirectory));
        $this->manager   = new Manager($this->migrator, $this->connector);
    }

    /**
     * Получить Manager
     *
     * @return ManagerInterface
     */
    public function getManager(): ManagerInterface
    {
        return $this->manager;
    }

    /**
     * Получить Migrator
     *
     * @return MigratorInterface
     */
    public function getMigrator(): MigratorInterface
    {
        return $this->migrator;
    }

    /**
     * Получить Connector
     *
     * @return ConnectorInterface
     */
    public function getConnector(): ConnectorInterface
    {
        return $this->connector;
    }
}
