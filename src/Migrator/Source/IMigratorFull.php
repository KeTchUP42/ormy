<?php
declare(strict_types = 1);

namespace ORMY\Migrator\Source;

/**
 * IMigrator with getters
 */
interface IMigratorFull extends IMigrator
{
    /**
     * Получить MigrDir
     *
     * @return string
     */
    public function getMigrDir(): string;

    /**
     * Получить MigrNameSpace
     *
     * @return string
     */
    public function getMigrNameSpace(): string;

    /**
     * Получить MigrVersionTableName
     *
     * @return string
     */
    public function getMigrVersionTableName(): string;
}
