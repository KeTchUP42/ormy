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
    public function fillRepository(string $className);

    /**
     * Method sends new info to db from container
     *
     * @return void
     */
    public function flush(): void;

    /**
     * Method builds QueryBuilder from container info
     *
     * @return IQueryBuilder
     */
    public function build(): IQueryBuilder;

    /**
     * Method cleans repository
     */
    public function clean(): void;

    /**
     * Method calls flush and clean
     */
    public function flush_and_clean(): void;
}
