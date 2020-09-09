<?php

namespace CustomShippingZone\Model\Base;

use \Exception;
use \PDO;
use CustomShippingZone\Model\CustomShippingZoneModules as ChildCustomShippingZoneModules;
use CustomShippingZone\Model\CustomShippingZoneModulesQuery as ChildCustomShippingZoneModulesQuery;
use CustomShippingZone\Model\Map\CustomShippingZoneModulesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\Module;

/**
 * Base class that represents a query for the 'custom_shipping_zone_modules' table.
 *
 *
 *
 * @method     ChildCustomShippingZoneModulesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCustomShippingZoneModulesQuery orderByCustomShippingZoneId($order = Criteria::ASC) Order by the custom_shipping_zone_id column
 * @method     ChildCustomShippingZoneModulesQuery orderByModuleId($order = Criteria::ASC) Order by the module_id column
 *
 * @method     ChildCustomShippingZoneModulesQuery groupById() Group by the id column
 * @method     ChildCustomShippingZoneModulesQuery groupByCustomShippingZoneId() Group by the custom_shipping_zone_id column
 * @method     ChildCustomShippingZoneModulesQuery groupByModuleId() Group by the module_id column
 *
 * @method     ChildCustomShippingZoneModulesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCustomShippingZoneModulesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCustomShippingZoneModulesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCustomShippingZoneModulesQuery leftJoinModule($relationAlias = null) Adds a LEFT JOIN clause to the query using the Module relation
 * @method     ChildCustomShippingZoneModulesQuery rightJoinModule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Module relation
 * @method     ChildCustomShippingZoneModulesQuery innerJoinModule($relationAlias = null) Adds a INNER JOIN clause to the query using the Module relation
 *
 * @method     ChildCustomShippingZoneModulesQuery leftJoinCustomShippingZone($relationAlias = null) Adds a LEFT JOIN clause to the query using the CustomShippingZone relation
 * @method     ChildCustomShippingZoneModulesQuery rightJoinCustomShippingZone($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CustomShippingZone relation
 * @method     ChildCustomShippingZoneModulesQuery innerJoinCustomShippingZone($relationAlias = null) Adds a INNER JOIN clause to the query using the CustomShippingZone relation
 *
 * @method     ChildCustomShippingZoneModules findOne(ConnectionInterface $con = null) Return the first ChildCustomShippingZoneModules matching the query
 * @method     ChildCustomShippingZoneModules findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCustomShippingZoneModules matching the query, or a new ChildCustomShippingZoneModules object populated from the query conditions when no match is found
 *
 * @method     ChildCustomShippingZoneModules findOneById(int $id) Return the first ChildCustomShippingZoneModules filtered by the id column
 * @method     ChildCustomShippingZoneModules findOneByCustomShippingZoneId(int $custom_shipping_zone_id) Return the first ChildCustomShippingZoneModules filtered by the custom_shipping_zone_id column
 * @method     ChildCustomShippingZoneModules findOneByModuleId(int $module_id) Return the first ChildCustomShippingZoneModules filtered by the module_id column
 *
 * @method     array findById(int $id) Return ChildCustomShippingZoneModules objects filtered by the id column
 * @method     array findByCustomShippingZoneId(int $custom_shipping_zone_id) Return ChildCustomShippingZoneModules objects filtered by the custom_shipping_zone_id column
 * @method     array findByModuleId(int $module_id) Return ChildCustomShippingZoneModules objects filtered by the module_id column
 *
 */
abstract class CustomShippingZoneModulesQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \CustomShippingZone\Model\Base\CustomShippingZoneModulesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\CustomShippingZone\\Model\\CustomShippingZoneModules', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCustomShippingZoneModulesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCustomShippingZoneModulesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \CustomShippingZone\Model\CustomShippingZoneModulesQuery) {
            return $criteria;
        }
        $query = new \CustomShippingZone\Model\CustomShippingZoneModulesQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCustomShippingZoneModules|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CustomShippingZoneModulesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CustomShippingZoneModulesTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildCustomShippingZoneModules A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, CUSTOM_SHIPPING_ZONE_ID, MODULE_ID FROM custom_shipping_zone_modules WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildCustomShippingZoneModules();
            $obj->hydrate($row);
            CustomShippingZoneModulesTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCustomShippingZoneModules|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildCustomShippingZoneModulesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CustomShippingZoneModulesTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCustomShippingZoneModulesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CustomShippingZoneModulesTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneModulesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CustomShippingZoneModulesTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CustomShippingZoneModulesTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomShippingZoneModulesTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the custom_shipping_zone_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomShippingZoneId(1234); // WHERE custom_shipping_zone_id = 1234
     * $query->filterByCustomShippingZoneId(array(12, 34)); // WHERE custom_shipping_zone_id IN (12, 34)
     * $query->filterByCustomShippingZoneId(array('min' => 12)); // WHERE custom_shipping_zone_id > 12
     * </code>
     *
     * @see       filterByCustomShippingZone()
     *
     * @param     mixed $customShippingZoneId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneModulesQuery The current query, for fluid interface
     */
    public function filterByCustomShippingZoneId($customShippingZoneId = null, $comparison = null)
    {
        if (is_array($customShippingZoneId)) {
            $useMinMax = false;
            if (isset($customShippingZoneId['min'])) {
                $this->addUsingAlias(CustomShippingZoneModulesTableMap::CUSTOM_SHIPPING_ZONE_ID, $customShippingZoneId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customShippingZoneId['max'])) {
                $this->addUsingAlias(CustomShippingZoneModulesTableMap::CUSTOM_SHIPPING_ZONE_ID, $customShippingZoneId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomShippingZoneModulesTableMap::CUSTOM_SHIPPING_ZONE_ID, $customShippingZoneId, $comparison);
    }

    /**
     * Filter the query on the module_id column
     *
     * Example usage:
     * <code>
     * $query->filterByModuleId(1234); // WHERE module_id = 1234
     * $query->filterByModuleId(array(12, 34)); // WHERE module_id IN (12, 34)
     * $query->filterByModuleId(array('min' => 12)); // WHERE module_id > 12
     * </code>
     *
     * @see       filterByModule()
     *
     * @param     mixed $moduleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneModulesQuery The current query, for fluid interface
     */
    public function filterByModuleId($moduleId = null, $comparison = null)
    {
        if (is_array($moduleId)) {
            $useMinMax = false;
            if (isset($moduleId['min'])) {
                $this->addUsingAlias(CustomShippingZoneModulesTableMap::MODULE_ID, $moduleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($moduleId['max'])) {
                $this->addUsingAlias(CustomShippingZoneModulesTableMap::MODULE_ID, $moduleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomShippingZoneModulesTableMap::MODULE_ID, $moduleId, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Module object
     *
     * @param \Thelia\Model\Module|ObjectCollection $module The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneModulesQuery The current query, for fluid interface
     */
    public function filterByModule($module, $comparison = null)
    {
        if ($module instanceof \Thelia\Model\Module) {
            return $this
                ->addUsingAlias(CustomShippingZoneModulesTableMap::MODULE_ID, $module->getId(), $comparison);
        } elseif ($module instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CustomShippingZoneModulesTableMap::MODULE_ID, $module->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByModule() only accepts arguments of type \Thelia\Model\Module or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Module relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCustomShippingZoneModulesQuery The current query, for fluid interface
     */
    public function joinModule($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Module');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Module');
        }

        return $this;
    }

    /**
     * Use the Module relation Module object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ModuleQuery A secondary query class using the current class as primary query
     */
    public function useModuleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinModule($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Module', '\Thelia\Model\ModuleQuery');
    }

    /**
     * Filter the query by a related \CustomShippingZone\Model\CustomShippingZone object
     *
     * @param \CustomShippingZone\Model\CustomShippingZone|ObjectCollection $customShippingZone The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCustomShippingZoneModulesQuery The current query, for fluid interface
     */
    public function filterByCustomShippingZone($customShippingZone, $comparison = null)
    {
        if ($customShippingZone instanceof \CustomShippingZone\Model\CustomShippingZone) {
            return $this
                ->addUsingAlias(CustomShippingZoneModulesTableMap::CUSTOM_SHIPPING_ZONE_ID, $customShippingZone->getId(), $comparison);
        } elseif ($customShippingZone instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CustomShippingZoneModulesTableMap::CUSTOM_SHIPPING_ZONE_ID, $customShippingZone->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCustomShippingZone() only accepts arguments of type \CustomShippingZone\Model\CustomShippingZone or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CustomShippingZone relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCustomShippingZoneModulesQuery The current query, for fluid interface
     */
    public function joinCustomShippingZone($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CustomShippingZone');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CustomShippingZone');
        }

        return $this;
    }

    /**
     * Use the CustomShippingZone relation CustomShippingZone object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \CustomShippingZone\Model\CustomShippingZoneQuery A secondary query class using the current class as primary query
     */
    public function useCustomShippingZoneQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCustomShippingZone($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CustomShippingZone', '\CustomShippingZone\Model\CustomShippingZoneQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCustomShippingZoneModules $customShippingZoneModules Object to remove from the list of results
     *
     * @return ChildCustomShippingZoneModulesQuery The current query, for fluid interface
     */
    public function prune($customShippingZoneModules = null)
    {
        if ($customShippingZoneModules) {
            $this->addUsingAlias(CustomShippingZoneModulesTableMap::ID, $customShippingZoneModules->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the custom_shipping_zone_modules table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomShippingZoneModulesTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CustomShippingZoneModulesTableMap::clearInstancePool();
            CustomShippingZoneModulesTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCustomShippingZoneModules or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCustomShippingZoneModules object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomShippingZoneModulesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CustomShippingZoneModulesTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        CustomShippingZoneModulesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CustomShippingZoneModulesTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // CustomShippingZoneModulesQuery
