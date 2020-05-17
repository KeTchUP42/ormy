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
     * Method creates new entity and put it to repository
     *
     * @param string $className
     *
     * @return bool|mixed
     */
    public function getRepository(string $className)
    {
        try {
            return new $className;
        } catch (Exception $exception) {
            return false;
        }
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
     * Method sends new info to db from repository
     *
     * @param $repository
     *
     * @return void
     */
    public function flush($repository): void
    {
        $this->build($repository)->exec();
    }

    /**
     * Method builds IQueryBuilder from container vars
     *
     * @param $repository
     *
     * @return IQueryBuilder
     */
    abstract public function build($repository): IQueryBuilder;
}
