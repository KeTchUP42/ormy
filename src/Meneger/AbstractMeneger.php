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
     * @param $entity
     *
     * @return void
     */
    public function flush(object $entity): void
    {
        $this->build($entity)->exec();
    }

    /**
     * Method builds IQueryBuilder from container vars
     *
     * @param $entity
     *
     * @return IQueryBuilder
     */
    abstract public function build(object $entity): IQueryBuilder;
}
