<?php
declare(strict_types = 1);

namespace ORMY\Meneger;

use Exception;
use ORMY\Connector\IConnector;

/**
 * ORM Meneger
 */
class Meneger implements IMeneger
{
    /**
     * @var IConnector
     */
    protected IConnector $connector;

    /**
     * @var mixed
     */
    protected $repository;

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
    public function getContainer(string $classPath)
    {
        try {
            $this->repository = new $classPath;
        } catch (Exception $exception) {
            return false;
        }

        return $this->repository;
    }

    /**
     * @return bool
     */
    public function flush(): bool
    {
        //$this->repository
        //todo!!!
        return true;
    }
}
