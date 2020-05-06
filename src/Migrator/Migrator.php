<?php
declare(strict_types = 1);

namespace ORMY\Migrator;

use ORMY\Connector\IConnector;
use ORMY\Exceptions\FileNotFoundException;
use ORMY\Migrator\Source\AbstractMigrator;
use ORMY\Migrator\Source\IDGenerator;
use PDO;

/**
 * ORM Migrator
 */
class Migrator extends AbstractMigrator
{
    /**
     * Configs form Migrator block in the ini config
     *
     * @var array
     */
    private array $migrConfigs;

    /**
     * Configs form MigrationTemplate block in the ini config
     *
     * @var array
     */
    private array $tempConfigs;

    /**
     * Конструктор.
     *
     * @param IConnector $connector
     * @param string     $migrDir
     * @param string     $migrNameSpace
     * @param string     $migrVersionTableName
     */
    public function __construct(
        IConnector $connector,
        string $migrDir,
        string $migrNameSpace,
        string $migrVersionTableName = 'migration_versions'
    ) {
        parent::__construct($connector,
            $migrDir,
            $migrNameSpace,
            ''
        );
        $this->migrVersionTableName = $this->connector->getProperty('dbname').'.'.$migrVersionTableName;
        $this->configure();
    }

    /**
     * Method loads configs from ini file
     */
    private function configure(): void
    {
        $configs           = parse_ini_file(__DIR__.'/config/migrator.ini', true);
        $this->migrConfigs = $configs['Migrator'];
        $this->tempConfigs = $configs['MigrationTemplate'];
    }

    /**
     * Method creates new migration and puts it the to migrations dir
     *
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): void
    {
        $tempPath = __DIR__.$this->migrConfigs['migrTemplatePath'];
        if (!file_exists($tempPath)) {
            throw new FileNotFoundException('Template file not found!');
        }
        $version = (new IDGenerator())->generateUniqueVersion($this->migrConfigs['migrPrefix']);

        file_put_contents($this->migrDir.'/'.$version.$this->migrConfigs['migrSuffix'],
            str_replace([
                $this->tempConfigs['version'],
                $this->tempConfigs['queryUp'],
                $this->tempConfigs['queryDown'],
                $this->tempConfigs['namespace'],
            ],
                [$version, $sqlQueryUp, $sqlQueryDown, $this->migrNameSpace],
                file_get_contents($tempPath)
            )
        );
    }

    /**
     * Method starts migrations and write their versions to db
     *
     * @return bool
     */
    public function migrateUp(): bool
    {
        $result = false;
        $this->createVersionTable();
        $versions = $this->selectAllVersions();
        foreach (glob($this->migrDir.'/'.$this->migrConfigs['migrPrefix'].'*'.$this->migrConfigs['migrSuffix']
        ) as $migrationFilePath) {
            if ($this->checkVersions($versions, $migrationFilePath, $this->migrConfigs['migrSuffix'])) {
                $migration = $this->migrNameSpace.'\\'.(basename($migrationFilePath, '.php'));
                (new $migration($this->connector))->up();
                $this->insertExecutedVersion(basename($migrationFilePath, $this->migrConfigs['migrSuffix']));
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
                $this->migrVersionTableName,
                file_get_contents(__DIR__.'/SQL/version_table_create.sql')
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
        return $this->connector->getQueryBuilder()
            ->select($this->migrVersionTableName, ['`version`'])
            ->query()
            ->fetchAll(PDO::FETCH_ASSOC
            );
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
    private function checkVersions(array $versions, string $migrationFilePath, string $migrationFilePathSuffix): bool
    {
        foreach ($versions as $value) {
            if ($value['version'] === basename($migrationFilePath, $migrationFilePathSuffix)) {
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
        $this->connector->getQueryBuilder()
            ->insert($this->migrVersionTableName, ['`version`'], ['\''.$version.'\''])
            ->exec();
    }

    /**
     * Method executes all down migrations methods
     *
     * @return bool
     */
    public function migrateDown(): bool
    {
        $result   = false;
        $versions = $this->selectAllVersions();
        foreach (array_reverse(glob($this->migrDir.'/'.$this->migrConfigs['migrPrefix'].'*'.$this->migrConfigs['migrSuffix'])
        ) as $migrationFilePath) {
            if (!$this->checkVersions($versions, $migrationFilePath, $this->migrConfigs['migrSuffix'])) {
                $migration = $this->migrNameSpace.'\\'.(basename($migrationFilePath, '.php'));
                (new $migration($this->connector))->down();
                $this->deleteRow(basename($migrationFilePath, $this->migrConfigs['migrSuffix']));
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
        $this->connector->getQueryBuilder()->delete($this->migrVersionTableName)->where('`version`', $version)->exec();
    }
}
