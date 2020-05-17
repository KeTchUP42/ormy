<?php
declare(strict_types = 1);

namespace ORMY\Meneger;

use ORMY\Connector\QueryBuilder\IQueryBuilder;
use ORMY\Exceptions\MenegerException;

/**
 * ORM Meneger
 */
class Meneger extends AbstractMeneger
{
    /**
     * Method builds IQueryBuilder from container vars
     *
     * @param $repository
     *
     * @return IQueryBuilder
     * @throws MenegerException
     */
    public function build($repository): IQueryBuilder
    {
        $this->valueValid($repository);
        $fields = [];
        $values = [];
        foreach ($this->objectVars($repository) as $key => $value) {
            $fields[] = "`$key`";
            $values[] = is_null($value) ? 'null' : (is_string($value) ? "'$value'" : $value);
        }
        $tableName = array_reverse(explode('\\',get_class($repository)))[0];
        $DBName    = ($this->connector->getDBName());
        $tableName = "`$DBName`.`$tableName`";

        return $this->connector->getQueryBuilder()->insert($tableName,$fields,$values);
    }

    /**
     * @param $value
     */
    private function valueValid($value): void
    {
        if (!is_object($value)) {
            throw new MenegerException('Value is not correct. Please, check it!');
        }
    }

    /**
     * Method returns repository's vars names and values
     *
     * @param $repository
     *
     * @return array
     */
    private function objectVars($repository): array
    {
        $this->valueValid($repository);
        $objVars['SRC_KEY'] = (array) $repository;
        foreach ($objVars['SRC_KEY'] as $key => $value) {
            $aux              = explode("\0",$key);
            $newkey           = $aux[count($aux) - 1];
            $objVars[$newkey] = &$objVars['SRC_KEY'][$key];
        }
        unset($objVars['SRC_KEY']);

        return $objVars;
    }
}
