<?php
declare(strict_types = 1);

namespace ORMY\Migrator;

use ORMY\Connector\IConnector;
use ORMY\Exceptions\FileNotFoundException;
use ORMY\Migrator\Id\IDGenerator;

/**
 * Migrator
 */
class Migrator extends AbstractMigrator
{
    /**
     * Configs from Migrator block from ini config
     *
     * @var array
     */
    private array $migrationConfigs;

    /**
     * Configs from MigrationTemplate block from ini config
     *
     * @var array
     */
    private array $templConfigs;

    /**
     * Конструктор.
     *
     * @param IConnector $connector
     * @param string     $migrationDir
     * @param string     $migrationNameSpace
     */
    public function __construct(
        IConnector $connector,
        string $migrationDir,
        string $migrationNameSpace
    ) {
        $this->configure();
        parent::__construct($connector,
            $migrationDir,
            $migrationNameSpace,
            $this->migrationConfigs['VersionTableName']
        );
    }

    /**
     * Method loads configs from ini file
     */
    private function configure(): void
    {
        $configs                          = parse_ini_file(__DIR__.'/config/migrator.ini',true);
        $this->migrationConfigs           = $configs['Migrator'];
        $this->templConfigs               = $configs['MigrationTemplate'];
        $this->migrationConfigs['suffix'] = basename($this->migrationConfigs['suffix'],'.php').'.php';
    }

    /**
     * Method creates new migration and puts it to the migrations dir
     *
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function makeMigration(string $sqlQueryUp,string $sqlQueryDown = ''): void
    {
        $tempPath = __DIR__.$this->migrationConfigs['TemplatePath'];
        if (!file_exists($tempPath)) {
            throw new FileNotFoundException('Template file not found!');
        }
        $version = (new IDGenerator())->generateUniqueVersion($this->migrationConfigs['prefix']);

        file_put_contents($this->migrationDir.'/'.$version.$this->migrationConfigs['suffix'],
            str_replace([
                $this->templConfigs['version'],
                $this->templConfigs['queryUp'],
                $this->templConfigs['queryDown'],
                $this->templConfigs['namespace']],
                [$version,$sqlQueryUp,$sqlQueryDown,$this->migrationNameSpace],
                file_get_contents($tempPath)
            )
        );
    }

    /**
     * Method calls up methods in new migrations
     * and writes to db new executed version
     *
     * @return bool
     */
    public function migrateUp(): bool
    {
        $result = false;
        $this->createVersionTable();
        $versions = $this->selectAllVersions();
        foreach (glob($this->migrationSearchPattern()) as $migrationFilePath) {
            if ($this->checkVersions($versions,$migrationFilePath,$this->migrationConfigs['suffix'])) {
                $migration = $this->migrationNameSpace.'\\'.(basename($migrationFilePath,'.php'));
                (new $migration($this->connector))->up();
                $this->insertExecutedVersion(basename($migrationFilePath,$this->migrationConfigs['suffix']));
                $result = true;
            }
        }

        return $result;
    }

    /**
     * Method creates version table if it doesn't exist
     */
    private function createVersionTable(): void
    {
        $this->connector->exec(str_replace(':tablename',
                $this->versionTableName,
                file_get_contents(__DIR__.'/sql/version_table_create.sql')
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
        return $this->connector->getQueryBuilder()->select($this->versionTableName,['`version`'])->query();
    }

    /**
     * Method makes shorter main part of code
     *
     * @return string
     */
    private function migrationSearchPattern(): string
    {
        return $this->migrationDir.'/'.$this->migrationConfigs['prefix'].'*'.$this->migrationConfigs['suffix'];
    }

    /**
     * Method returns true if migration have never been executed
     *
     * @param array  $versions
     * @param string $migrationFilePath
     *
     * @param string $migrationFilePathSuffix
     *
     * @return bool
     */
    private function checkVersions(array $versions,string $migrationFilePath,string $migrationFilePathSuffix): bool
    {
        foreach ($versions as $value) {
            if ($value['version'] === basename($migrationFilePath,$migrationFilePathSuffix)) {
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
        $this->connector->getQueryBuilder()->insert($this->versionTableName,['`version`'],["'$version'"])->exec();
    }

    /**
     * Method calls all down methods in migrations
     * and deletes all executed versions from db
     *
     * @return bool
     */
    public function migrateDown(): bool
    {
        $result   = false;
        $versions = $this->selectAllVersions();
        foreach (array_reverse(glob($this->migrationSearchPattern())) as $migrationFilePath) {
            if (!$this->checkVersions($versions,$migrationFilePath,$this->migrationConfigs['suffix'])) {
                $migration = $this->migrationNameSpace.'\\'.(basename($migrationFilePath,'.php'));
                (new $migration($this->connector))->down();
                $this->deleteRow(basename($migrationFilePath,$this->migrationConfigs['suffix']));
                $result = true;
            }
        }

        return $result;
    }

    /**
     * Method deletes row where version = $version
     *
     * @param string $version
     */
    private function deleteRow(string $version): void
    {
        $this->connector->getQueryBuilder()->delete($this->versionTableName)->where('`version`',$version)->exec();
    }
}
