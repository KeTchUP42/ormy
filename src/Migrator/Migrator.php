<?php
declare(strict_types = 1);

namespace ORMY\Migrator;

use ORMY\Connector\ConnectorInterface;
use ORMY\Exceptions\FileNotFoundException;
use ORMY\Migrator\Id\IDGenerator;

/**
 * Migrator
 */
class Migrator extends AbstractMigrator
{
    /**
     * Configs from Migrator block in ini config
     *
     * @var array
     */
    private array $migrationIni;

    /**
     * Configs from MigrationTemplate block in ini config
     *
     * @var array
     */
    private array $templIni;

    /**
     * Конструктор.
     *
     * @param ConnectorInterface $connector
     * @param string             $migrationDirectory
     * @param string             $migrationNameSpace
     */
    public function __construct(
        ConnectorInterface $connector,
        string $migrationDirectory,
        string $migrationNameSpace
    ) {
        $this->configure();
        parent::__construct(
            $connector,
            $migrationDirectory,
            $migrationNameSpace,
            $this->migrationIni['VersionTableName']
        );
    }

    /**
     * Method loads configs from ini file
     */
    private function configure(): void
    {
        $configs                      = parse_ini_file(__DIR__.'/config/migrator.ini', true);
        $this->migrationIni           = $configs['Migrator'];
        $this->templIni               = $configs['MigrationTemplate'];
        $this->migrationIni['suffix'] = basename($this->migrationIni['suffix'], '.php').'.php';
    }

    /**
     * Method creates new migration and puts it to the migration's dir.
     *
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): void
    {
        $tempPath = __DIR__.$this->migrationIni['TemplatePath'];
        if (!file_exists($tempPath)) {
            throw new FileNotFoundException('Migration template file not found!');
        }
        $version = IDGenerator::generateVersion($this->migrationIni['prefix']);
        file_put_contents(
            $this->migrationDirectory.'/'.$version.$this->migrationIni['suffix'],
            str_replace(
                [
                    $this->templIni['version'],
                    $this->templIni['queryUp'],
                    $this->templIni['queryDown'],
                    $this->templIni['namespace']
                ],
                [$version, $sqlQueryUp, $sqlQueryDown, $this->migrationNameSpace],
                file_get_contents($tempPath)
            )
        );
    }

    /**
     * Method calls `up` method in new migrations and updates version table.
     *
     * @return void
     */
    public function migrateUp(): void
    {
        $this->createVersionTable();
        foreach ($this->searchMigrations() as $migrationFilePath) {
            if ($this->checkVersion($migrationFilePath)) {
                $migration = $this->migrationNameSpace.'\\'.(basename($migrationFilePath, '.php'));
                (new $migration($this->connector))->up();
                $this->insertExecutedVersion(basename($migrationFilePath, $this->migrationIni['suffix']));
            }
        }
    }

    /**
     * Method creates version table if it doesn't exist
     */
    private function createVersionTable(): void
    {
        $this->connector->exec(
            str_replace(
                ':tablename',
                $this->versionTableName,
                file_get_contents(__DIR__.'/sql/VersionTableCreate.sql')
            )
        );
    }

    /**
     * Method selects all migration versions from db
     *
     * @return array
     */
    private function selectAllVersions(): array
    {
        return $this->connector->getQueryBuilder()->select($this->versionTableName, ['`version`'])->query();
    }

    /**
     * Method makes shorter main part of code
     *
     * @return array
     */
    private function searchMigrations(): array
    {
        return glob($this->migrationDirectory.'/'.$this->migrationIni['prefix'].'*'.$this->migrationIni['suffix']);
    }

    /**
     * Method returns true if migration have never been executed
     *
     * @param string $migrationFilePath
     *
     * @return bool
     */
    private function checkVersion(string $migrationFilePath): bool
    {
        foreach ($this->selectAllVersions() as $value) {
            if ($value['version'] === basename($migrationFilePath, $this->migrationIni['suffix'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Method inserts new migration version to db
     *
     * @param string $version
     */
    private function insertExecutedVersion(string $version): void
    {
        $this->connector->getQueryBuilder()->insert($this->versionTableName, ['`version`'], ["'$version'"])->exec();
    }

    /**
     * Method calls `down` method in migrations and deletes all executed versions from db
     *
     * @return void
     */
    public function migrateDown(): void
    {
        foreach (array_reverse($this->searchMigrations()) as $migrationFilePath) {
            if (!$this->checkVersion($migrationFilePath)) {
                $migration = $this->migrationNameSpace.'\\'.(basename($migrationFilePath, '.php'));
                (new $migration($this->connector))->down();
                $this->deleteRow(basename($migrationFilePath, $this->migrationIni['suffix']));
            }
        }
    }

    /**
     * Method deletes row where version == $version
     *
     * @param string $version
     */
    private function deleteRow(string $version): void
    {
        $this->connector->getQueryBuilder()->delete($this->versionTableName)->where('`version`', $version)->exec();
    }
}
