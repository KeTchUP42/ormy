<?php
declare(strict_types = 1);

namespace ORMY\Manager;

use ORMY\Connector\QueryBuilder\QueryBuilderInterface;
use ORMY\Traits\ConnectorTrait;

/**
 * AbstractMeneger
 */
abstract class AbstractManager implements ManagerInterface
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
     * @return QueryBuilderInterface
     */
    public function buildQuery(): QueryBuilderInterface
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
     * @return QueryBuilderInterface
     */
    abstract public function build(object $entity): QueryBuilderInterface;

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
