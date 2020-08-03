<?php
declare(strict_types = 1);

namespace ORMY\Manager;

use ORMY\Connector\ConnectorInterface;
use ORMY\Connector\QueryBuilder\QueryBuilderInterface;
use ORMY\Exceptions\FileNotFoundException;
use ORMY\Migrator\MigratorInterface;

/**
 * AbstractManager
 */
abstract class AbstractManager implements ManagerInterface
{
    /**
     * @var MigratorInterface
     */
    protected MigratorInterface $migrator;

    /**
     * @var ConnectorInterface
     */
    protected ConnectorInterface $connector;

    /**
     * Array of prepared entities
     *
     * @var array
     */
    protected array $prepared = [];

    /**
     * Конструктор.
     *
     * @param MigratorInterface  $migrator
     * @param ConnectorInterface $connector
     */
    public function __construct(MigratorInterface $migrator, ConnectorInterface $connector)
    {
        $this->migrator  = $migrator;
        $this->connector = $connector;
    }

    /**
     * Method makes code shorter
     *
     * @return QueryBuilderInterface
     */
    public function buildQuery(): QueryBuilderInterface
    {
        return $this->connector->createQueryBuilder();
    }

    /**
     * Method sends new info to db from prepared[]
     *
     * @param bool $migrate
     *
     * @return void
     */
    public function flush(bool $migrate = false): void
    {
        foreach ($this->prepared as $entity) {
            $query = $this->build($entity);
            $query->exec();
            if ($migrate) {
                $this->migrator->makeMigration($query->getSQL());
            }
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
     * Method makes migration from param entity
     *
     * @param object $entity
     *
     * @throws FileNotFoundException
     */
    public function migrate(object $entity): void
    {
        $this->migrator->makeMigration($this->build($entity)->getSQL());
    }

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
