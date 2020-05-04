<?php
declare(strict_types = 1);

namespace ORMY\Migrator;

use ORMY\Migrator\source\AbstractMigrator;

/**
 * ORM Migrator
 */
class Migrator extends AbstractMigrator
{
    /**
     * @var string
     */
    protected string $migrationTemplatePath = __DIR__ . '/Migrations/templates/Migration.txt';

    /**
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return bool
     */
    public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): bool
    {
        if (!file_exists($this->migrationTemplatePath)) {
            return false;
        }
        $version = str_replace('.', '', uniqid('m', true));
        file_put_contents(
            $this->migrationsDir . '/' . $version . 'Migration.php',
            str_replace(
                ['<version>', '<queryUP>', '<queryDOWN>'],
                [$version, $sqlQueryUp, $sqlQueryDown],
                file_get_contents($this->migrationTemplatePath)
            )
        );
        $this->connector->exec(
            str_replace(
                '<tablename>',
                $this->migrationVersionTableName,
                file_get_contents(__DIR__ . '/sql/version_table_create.sql')
            )
        );
        $this->connector->exec(
            str_replace(
                ['<tablename>', '<version>'],
                [$this->migrationVersionTableName, $version],
                file_get_contents(__DIR__ . '/sql/new_migration_version.sql')
            )
        );

        return true;
    }

    /**
     *
     * @return bool
     */
    public function migrateUp(): bool
    {
        // TODO: Implement migrateUp() method.
        return false;
    }

    /**
     *
     * @return bool
     */
    public function migrateDown(): bool
    {
        // TODO: Implement migrateDown() method.
        return false;
    }
}
