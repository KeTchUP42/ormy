<?php
declare(strict_types = 1);

namespace ORMY\Meneger;

use ORMY\Connector\QueryBuilder\IQueryBuilder;

/**
 * IMeneger
 */
interface IMeneger
{
    /**
     * Method makes code shorter
     *
     * @return IQueryBuilder
     */
    public function buildQuery(): IQueryBuilder;

    /**
     * Method creates new entity and put it to the repository
     *
     * @param string $className
     *
     * @return bool|mixed
     */
    public function getRepository(string $className);

    /**
     * Method sends new info to db from container
     *
     * @param object $entity
     *
     * @return void
     */
    public function flush(object $entity): void;

    /**
     * Method builds QueryBuilder from container info
     *
     * @param object $entity
     *
     * @return IQueryBuilder
     */
    public function build(object $entity): IQueryBuilder;
}
