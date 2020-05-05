<?php
declare(strict_types = 1);

namespace ORMY\Migrator;

use ORMY\Connector\IConnector;
use ORMY\Exceptions\FileNotFoundException;
use ORMY\Migrator\Source\AbstractMigrator;
use PDO;

/**
 * ORM Migrator
 */
class Migrator extends AbstractMigrator
{
    /**
     * @var int
     */
    private static int $migrVersionCorrector = 0;

    /**
     * Configs form Migrator block in the ini config
     *
     * @var array
     */
    private array $migrConfigs;

    /**
     *Configs form MigrationTemplate block in the ini config
     *
     * @var array
     */
    private array $tempConfigs;

    /**
     * Конструктор.
     *
     * @param IConnector $connector
     * @param string     $migrDir
     * @param string     $migrVersionTableName
     */
    public function __construct(
        IConnector $connector,
        string $migrDir,
        string $migrVersionTableName = 'migration_versions'
    ) {
        parent::__construct(
            $connector,
            $migrDir,
            basename($migrDir),
            ''
        );
        $this->migrVersionTableName = $this->connector->getProperty('dbname') . '.' . $migrVersionTableName;
        $configs                    = parse_ini_file(__DIR__ . '/config/migrator.ini', true);
        $this->migrConfigs          = $configs['Migrator'];
        $this->tempConfigs          = $configs['MigrationTemplate'];
    }

    /**
     * @param string $sqlQueryUp
     * @param string $sqlQueryDown
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function makeMigration(string $sqlQueryUp, string $sqlQueryDown = ''): void
    {
        $tempPath = __DIR__ . $this->migrConfigs['migrTemplatePath'];
        if (!file_exists($tempPath)) {
            throw new FileNotFoundException('Template file not found!');
        }
        $version = $this->generateUniqueVersion();

        file_put_contents(
            $this->migrDir . '/' . $version . $this->migrConfigs['migrSuffix'],
            str_replace(
                [
                    $this->tempConfigs['version'],
                    $this->tempConfigs['queryUp'],
                    $this->tempConfigs['queryDown'],
                    $this->tempConfigs['namespace']
                ],
                [$version, $sqlQueryUp, $sqlQueryDown, $this->migrNameSpace],
                file_get_contents($tempPath)
            )
        );
    }

    /**
     * Method returns unique string
     *
     * @return string
     */
    private function generateUniqueVersion(): string
    {
        return $this->migrConfigs['migrPrefix'] .
            ((new \DateTime())->getTimestamp() + $this::$migrVersionCorrector++);
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
        foreach (glob(
                     $this->migrDir . '/' . $this->migrConfigs['migrPrefix'] . '*' . $this->migrConfigs['migrSuffix']
                 ) as $migrationFilePath) {
            if ($this->checkVersions($versions, $migrationFilePath, $this->migrConfigs['migrSuffix'])) {
                $migration = $this->migrNameSpace . '\\' . (basename($migrationFilePath, '.php'));
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
        $this->connector->exec(
            str_replace(
                ':tablename',
                $this->migrVersionTableName,
                file_get_contents(__DIR__ . '/sql/version_table_create.sql')
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
            ->fetchAll(
                PDO::FETCH_ASSOC
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
            ->insert($this->migrVersionTableName, ['`version`'], ['\'' . $version . '\''])->exec();
    }

    /**
     * Method executes all down migrations methods
     *
     * @return bool
     */
    public function migrateDown(): bool
    {
        // TODO: Implement migrateDown() method.
        return false;
    }

    /**
     * Method deletes row where version = $version
     *
     * @param string $version
     */
    private function deleteRow(string $version): void
    {
        $this->connector->getQueryBuilder()
            ->delete($this->migrVersionTableName)
            ->where('`version`', $version)->exec();
    }
}
