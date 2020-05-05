<?php
declare(strict_types = 1);

namespace ORMY\Meneger;

use Exception;
use ORMY\Connector\IConnector;

/**
 * AbstractMeneger
 */
abstract class AbstractMeneger implements IMeneger
{
    /**
     * @var mixed
     */
    protected $repository;

    /**
     * @var IConnector
     */
    private IConnector $connector;

    /**
     * Конструктор.
     *
     * @param IConnector $connector
     */
    public function __construct(IConnector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @return IConnector
     */
    public function getConnector(): IConnector
    {
        return $this->connector;
    }

    /**
     *
     * @param string $classPath
     *
     * @return bool|mixed
     */
    public function installRepository(string $classPath)
    {
        try {
            $this->repository = new $classPath;
        } catch (Exception $exception) {
            return false;
        }

        return $this->repository;
    }

    /**
     * Method sends new info to db from container
     *
     * @return bool
     */
    abstract public function flush(): bool;
}
