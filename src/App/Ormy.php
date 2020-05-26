<?php
declare(strict_types = 1);

namespace ORMY\App;

use ORMY\Connector\Connector;
use ORMY\Connector\IConnector;
use ORMY\Exceptions\ConnectionException;
use ORMY\Meneger\IMeneger;
use ORMY\Meneger\Meneger;
use ORMY\Migrator\IMigrator;
use ORMY\Migrator\Migrator;

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
        $this->meneger   = new Meneger($this->connector);
        $this->migrator  = new Migrator($this->connector,$migrationDir,$migrationNameSpace ?? basename($migrationDir)
        );
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
     * @return IConnector
     */
    public function getConnector(): IConnector
    {
        return $this->connector;
    }
}
