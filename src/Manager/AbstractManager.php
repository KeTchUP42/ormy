<?php
declare(strict_types = 1);

namespace ORMY\Manager;

use ORMY\Connector\QueryBuilder\IQueryBuilder;
use ORMY\Traits\ConnectorTrait;

/**
 * AbstractMeneger
 */
abstract class AbstractManager implements IManager
{
    use ConnectorTrait;

    /**
     * Array of prepared entities
     *
     * @var array
     */
    protected array $prepared = [];

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
     * Method sends new info to db from prepared[]
     *
     * @return void
     */
    public function flush(): void
    {
        foreach ($this->prepared as $value) {
            $this->build($value)->exec();
        }
        $this->prepared = [];
    }

    /**
     * Method builds QueryBuilder for entity
     *
     * @param $entity
     *
     * @return IQueryBuilder
     */
    abstract public function build(object $entity): IQueryBuilder;

    /**
     * Method registers new entity
     *
     * @param object $entity
     */
    public function persist(object $entity): void
    {
        $this->prepared[] = $entity;
    }

    /**
     * Method sends new info to db
     *
     * @param $entity
     *
     * @return void
     */
    public function send(object $entity): void
    {
        $this->build($entity)->exec();
    }
}
