<?php
declare(strict_types = 1);

namespace ORMY\Manager;

use ORMY\Connector\QueryBuilder\QueryBuilderInterface;

/**
 * ORM Meneger
 */
class Manager extends AbstractManager
{
    /**
     * Method builds QueryBuilder for entity
     *
     * @param object $entity
     *
     * @return QueryBuilderInterface
     */
    public function build(object $entity): QueryBuilderInterface
    {
        $columns = [];
        $values  = [];
        foreach ($this->object_vars($entity) as $key => $value) {
            if (!is_object($value) && !is_array($value) && !is_resource($value)) {
                $columns[] = "`$key`";
                $values[]  = $this->typeConvert($value);
            }
        }
        $tableName = $this->get_class_name(get_class($entity));
        $DBName    = ($this->connector->getDBName());
        $tableName = "`$DBName`.`$tableName`";

        return $this->connector->getQueryBuilder()->insert($tableName, $columns, $values);
    }

    /**
     * Method returns repository's vars array
     *
     * @param object $object
     *
     * @return array
     */
    private function object_vars(object $object): array
    {
        $objectVars['SRC_KEY'] = (array) $object;
        foreach ($objectVars['SRC_KEY'] as $key => $value) {
            $aux                 = explode("\0", $key);
            $newkey              = $aux[count($aux) - 1];
            $objectVars[$newkey] = &$objectVars['SRC_KEY'][$key];
        }
        unset($objectVars['SRC_KEY']);

        return $objectVars;
    }

    /**
     * Method returns sql valid converted value
     *
     * @param mixed $value
     *
     * @return string
     */
    private function typeConvert($value): string
    {
        if (is_null($value)) {
            return 'NULL';
        }
        if (is_bool($value)) {
            return $value ? 'TRUE' : 'FALSE';
        }
        if (is_string($value)) {
            return "'$value'";
        }

        return (string) $value;
    }

    /**
     * Method returns short class name
     *
     * @param $classname
     *
     * @return string
     */
    private function get_class_name(string $classname): string
    {
        $pos = strrpos($classname, '\\');
        if ($pos) {
            return substr($classname, $pos + 1);
        }

        return $classname;
    }
}
