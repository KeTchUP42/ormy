<?php
declare(strict_types = 1);

namespace ORMY\Manager;

use ORMY\Connector\QueryBuilder\QueryBuilderInterface;

/**
 * IMeneger
 */
interface ManagerInterface
{
    /**
     * Method makes code shorter
     *
     * @return QueryBuilderInterface
     */
    public function buildQuery(): QueryBuilderInterface;

    /**
     * Method sends new info to db from prepared[]
     *
     * @return void
     */
    public function flush(): void;

    /**
     * Method registers new entity
     *
     * @param object $entity
     */
    public function persist(object $entity): void;

    /**
     * Method sends new info to db
     *
     * @param $entity
     *
     * @return void
     */
    public function send(object $entity): void;

    /**
     * Method builds QueryBuilder for entity
     *
     * @param object $entity
     *
     * @return QueryBuilderInterface
     */
    public function build(object $entity): QueryBuilderInterface;
}
