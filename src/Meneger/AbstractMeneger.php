<?php
declare(strict_types = 1);

namespace ORMY\Meneger;

use Exception;
use ORMY\Connector\QueryBuilder\IQueryBuilder;
use ORMY\Traits\ConnectorTrait;

/**
 * AbstractMeneger
 */
abstract class AbstractMeneger implements IMeneger
{
    use ConnectorTrait;

    /**
     * @var mixed
     */
    protected $repository;

    /**
     * @var string
     */
    protected ?string       $tableName;

    /**
     * Method creates new entity and put it to repository
     *
     * @param string $className
     *
     * @return bool|mixed
     */
    public function fillRepository(string $className)
    {
        try {
            $this->repository = new $className;
            $this->tableName  = array_reverse(explode('\\',$className))[0];
        } catch (Exception $exception) {
            return false;
        }

        return $this->repository;
    }

    /**
     * Method makes code shorter
     *
     * @return IQueryBuilder
     */
    public function buildQuery(): IQueryBuilder
    {
        return $this->connector->getQueryBuilder();
    }

    /**
     * Method calls flush and clean
     */
    public function flush_and_clean(): void
    {
        $this->flush();
        $this->clean();
    }

    /**
     * Method sends new info to db from repository
     *
     * @return void
     */
    public function flush(): void
    {
        $this->build()->exec();
    }

    /**
     * Method builds IQueryBuilder from container vars
     *
     * @return IQueryBuilder
     */
    abstract public function build(): IQueryBuilder;

    /**
     * Method cleans repository
     */
    public function clean(): void
    {
        $this->tableName  = null;
        $this->repository = null;
    }
}
