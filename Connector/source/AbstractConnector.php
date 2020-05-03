<?php
declare(strict_types = 1);

namespace ORMY\Connector\source;

use ORMY\Connector\QueryBuilder\IQueryBuilder;
use PDO;

/**
 * AbstractConnector
 */
abstract class AbstractConnector implements IConnector
{
    /**
     * @var PDO
     */
    protected PDO   $pdo;

    /**
     * @var array
     */
    protected array $properties;

    /**
     * Конструктор.
     *
     * @param string $dsn
     * @param string $host
     * @param string $pass
     */
    public function __construct(string $dsn, string $host, string $pass)
    {
        try {
            $this->pdo = new PDO($dsn, $host, $pass);
        } catch (\PDOException $exception) {
            die('I cant connect to DB, check input args:' . __FILE__ . ' ' . __LINE__ . "\n" . $exception->errorInfo);
        }
        $this->parseDsn($dsn);
    }

    /**
     *
     * @param string $dsn
     */
    protected function parseDsn(string $dsn): void
    {
        $body = explode(':', mb_strtolower($dsn));
        foreach (explode(';', $body[1]) as $value) {
            $propertyKeyValue                       = explode('=', $value);
            $this->properties[$propertyKeyValue[0]] = $propertyKeyValue[1];
        }
    }

    /**
     * Получить Properties
     *
     * @param string $name
     *
     * @return bool|mixed
     */
    public function getProperty(string $name)
    {
        return $this->properties[$name] ?? false;
    }

    /**
     * Получить Pdo
     *
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     *
     * @param string $sqlquery
     *
     * @return bool|false|int
     */
    abstract public function exec(string $sqlquery);

    /**
     *
     * @param string $sqlquery
     *
     * @return bool|false|\PDOStatement
     */
    abstract public function query(string $sqlquery);

    /**
     *
     * @return IQueryBuilder
     */
    abstract public function getQueryBuilder(): IQueryBuilder;
}
