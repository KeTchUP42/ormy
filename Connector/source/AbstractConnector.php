<?php
declare(strict_types = 1);

namespace ORMY\Connector\source;

use ORMY\Connector\QueryBuilder\IQueryBuilder;
use PDO;

/**
 * AbstractConnector
 */
abstract class AbstractConnector implements IConnector, IConnectorSafe
{
    /**
     * @var PDO
     */
    protected PDO   $pdo;

    /**
     * @var string
     */
    protected string $dbName;

    /**
     * @var string
     */
    protected string $address;

    /**
     * @var string
     */
    protected string $host;

    /**
     * Конструктор.
     *
     * @param string $dbType
     * @param string $address
     * @param string $port
     * @param string $dbName
     * @param string $host
     * @param string $pass
     */
    public function __construct(
        string $dbType,
        string $address,
        string $port,
        string $dbName,
        string $host,
        string $pass
    ) {
        try {
            $this->pdo = new PDO("$dbType:host=$address;port=$port;dbname=$dbName", $host, $pass);
        } catch (\PDOException $exception) {
            die('I cant connect to DB, check input args:' . __FILE__ . "\n" . $exception->errorInfo);
        }
        $this->dbName  = $dbName;
        $this->address = $address . ':' . $port;
        $this->host    = $host;
    }

    /**
     * Получить Address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Получить Host
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     *
     * @return string
     */
    public function getDBName(): string
    {
        return $this->dbName;
    }

    /**
     *
     * @param string $sqlquery
     *
     * @return array
     */
    abstract public function queryAll(string $sqlquery): array;

    /**
     *
     * @param string $sqlquery
     *
     * @param int    $style
     *
     * @return array
     */
    abstract public function query(string $sqlquery, int $style = PDO::FETCH_BOTH): array;

    /**
     *
     * @return IQueryBuilder
     */
    abstract public function getQueryBuilder(): IQueryBuilder;
}
