<?php
declare(strict_types = 1);

namespace ORMY\App;

use ORMY\Meneger\Meneger;
use ORMY\Migrator\Source\IMigrator;
use ORMY\Migrator\Source\IMigratorFull;

/**
 *  IOrmy params
 */
interface IOrmy
{
    public const NAMESPACE_AUTO = 'auto';

    /**
     * Reset Migrator.
     *
     * @param string $migrationDir
     *
     * @param string $migrationNameSpace
     * @param string $migrationVerTableName
     *
     * @return Ormy
     */
    public function resetMigrator(
        string $migrationVerTableName,
        string $migrationDir,
        string $migrationNameSpace = self::NAMESPACE_AUTO
    ): Ormy;

    /**
     * Получить Meneger
     *
     * @return Meneger
     */
    public function getMeneger(): Meneger;

    /**
     * Получить Migrator
     *
     * @return IMigrator
     */
    public function getMigrator(): IMigrator;

    /**
     * Получить Migrator
     *
     * @return IMigratorFull
     */
    public function getFullMigrator(): IMigratorFull;
}
