<?php
declare(strict_types = 1);

namespace ORMY\Migrator\Source;

/**
 * IMigrator with getters
 */
interface IMigratorFull extends IMigrator
{
    /**
     * Получить Migration dir
     *
     * @return string
     */
    public function getMigrationDir(): string;

    /**
     * Получить Migration namespace
     *
     * @return string
     */
    public function getMigrationNameSpace(): string;

    /**
     * Получить migration version table name
     *
     * @return string
     */
    public function getMigrationVersionTableName(): string;
}
