<?php
declare(strict_types = 1);

namespace ORMY\Meneger;

use ORMY\Connector\QueryBuilder\IQueryBuilder;
use ORMY\Exceptions\EmptyRepositoryException;

/**
 * ORM Meneger
 */
class Meneger extends AbstractMeneger
{
    /**
     * Method builds IQueryBuilder from container vars
     *
     * @return IQueryBuilder
     */
    public function build(): IQueryBuilder
    {
        if (is_null($this->tableName) || is_null($this->repository)) {
            throw new EmptyRepositoryException('Repository is empty! Please, fill it.');
        }
        $fields = [];
        $values = [];
        foreach ($this->objectVars() as $key => $value) {
            $fields[] = "`$key`";
            $values[] = is_null($value) ? 'null' : (is_string($value) ? "'$value'" : $value);
        }

        return $this->connector->getQueryBuilder()->insert($this->tableName,$fields,$values);
    }

    /**
     * Method returns repository's vars names and values
     *
     * @return array
     */
    private function objectVars(): array
    {
        $objVars['SRC_KEY'] = (array) $this->repository;
        foreach ($objVars['SRC_KEY'] as $key => $value) {
            $aux              = explode("\0",$key);
            $newkey           = $aux[count($aux) - 1];
            $objVars[$newkey] = &$objVars['SRC_KEY'][$key];
        }
        unset($objVars['SRC_KEY']);

        return $objVars;
    }
}
