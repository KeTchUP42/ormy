<?php
declare(strict_types = 1);

namespace ORMY\Manager;

use ORMY\Connector\QueryBuilder\IQueryBuilder;

/**
 * IMeneger
 */
interface IManager
{
    /**
     * Method makes code shorter
     *
     * @return IQueryBuilder
     */
    public function buildQuery(): IQueryBuilder;

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
     * Method builds QueryBuilder from container info
     *
     * @param object $entity
     *
     * @return IQueryBuilder
     */
    public function build(object $entity): IQueryBuilder;
}
