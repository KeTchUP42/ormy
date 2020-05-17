<?php
declare(strict_types = 1);

namespace ORMY\Meneger;

use ORMY\Connector\QueryBuilder\IQueryBuilder;

/**
 * ORM Meneger
 */
class Meneger extends AbstractMeneger
{
    /**
     * Method builds IQueryBuilder from container vars
     *
     * @param object $entity
     *
     * @return IQueryBuilder
     */
    public function build(object $entity): IQueryBuilder
    {
        $fields = [];
        $values = [];
        foreach ($this->object_vars($entity) as $key => $value) {
            $fields[] = "`$key`";
            $values[] = is_null($value) ? 'null' : (is_string($value) ? "'$value'" : $value);
        }
        $tableName = $this->get_class_name(get_class($entity));
        $DBName    = ($this->connector->getDBName());
        $tableName = "`$DBName`.`$tableName`";

        return $this->connector->getQueryBuilder()->insert($tableName,$fields,$values);
    }

    /**
     * Method returns repository's vars names and values
     *
     * @param object $object
     *
     * @return array
     */
    private function object_vars(object $object): array
    {
        $objVars['SRC_KEY'] = (array) $object;
        foreach ($objVars['SRC_KEY'] as $key => $value) {
            $aux              = explode("\0",$key);
            $newkey           = $aux[count($aux) - 1];
            $objVars[$newkey] = &$objVars['SRC_KEY'][$key];
        }
        unset($objVars['SRC_KEY']);

        return $objVars;
    }

    /**
     * Method returns shorm class name
     *
     * @param $classname
     *
     * @return string
     */
    private function get_class_name(string $classname): string
    {
        $pos = strrpos($classname,'\\');
        if ($pos) {
            return substr($classname,$pos + 1);
        }

        return $classname;
    }
}
